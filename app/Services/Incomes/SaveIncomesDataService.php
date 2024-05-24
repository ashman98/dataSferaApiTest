<?php

namespace App\Services\Incomes;

use App\Exceptions\ApiValidationException;
use App\Exceptions\CustomApiException;
use App\Interfaces\DataSferaCallApiInterface;
use App\Interfaces\Incomes\SaveIncomesDataInterface;
use App\Services\AbstractServices\SaveIntegrationDataAbstract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Facades\Octane;

class SaveIncomesDataService extends SaveIntegrationDataAbstract implements SaveIncomesDataInterface
{
    /**
     * @param DataSferaCallApiInterface $dataSferaCallApiService
     */
    public function __construct(DataSferaCallApiInterface $dataSferaCallApiService)
    {
        parent::__construct($dataSferaCallApiService);
    }

    /**
     * @param string $endpoint
     * @param string $token
     * @param array $body
     * @return void
     * @throws ApiValidationException
     */
    public function save(string $endpoint,string $token, array $body):void
    {
        $this->dataSferaCallApiService->setEndpoint($endpoint)->setToken($token)->setBody($body);
        $initialResponse = $this->dataSferaCallApiService->callApiGet()->getResult();

        if (empty($initialResponse)) {
            throw new ApiValidationException('Failed to fetch data: No initial response',500);
        }
        if (!isset($initialResponse['meta']['last_page'])) {
            throw new ApiValidationException('Failed to fetch data: No pagination info',500);
        }
        try {
            $pageCount = $initialResponse['meta']['last_page'];
            $tasks = array_map(function ($page) use ($body) {
                return function () use ($page, $body) {
                    try {
                        $results = $this->dataSferaCallApiService->setBody(array_merge($body, ['page' => $page]))
                            ->callApiGet()->getResult();

                        if (empty($results)){
                            throw new  CustomApiException('Data not found pls change range');
                        }

                        DB::transaction(function () use ($page, $results) {
                            $dataToInsert = [];
                            if (isset($results['data'])) {
                                foreach ($results['data'] as $item) {
                                    $dataToInsert[] = [
                                        'income_id' => $item['income_id'],
                                        'number' => $item['number'],
                                        'date' => $item['date'],
                                        'last_change_date' => $item['last_change_date'],
                                        'supplier_article' => $item['supplier_article'],
                                        'tech_size' => $item['tech_size'],
                                        'barcode' => $item['barcode'],
                                        'quantity' => $item['quantity'],
                                        'total_price' => $item['total_price'],
                                        'date_close' => $item['date_close'],
                                        'warehouse_name' => $item['warehouse_name'],
                                        'nm_id' => $item['nm_id'],
                                        'status' => $item['status'],
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                }
                            }

                            if (!empty($dataToInsert)) {
                                DB::table('incomes')->insert($dataToInsert);
                                Log::info("Inserted data for page {$page}", ['count' => count($dataToInsert)]);
                            } else {
                                Log::warning("No data to insert for page {$page}");
                            }
                        });
                    } catch (\Throwable $e) {
                        Log::error("Error processing page {$page}: " . $e->getMessage());
                    }
                };
            }, range(1, $pageCount));

            $chunkSize = 20; // Reduce chunk size to lower concurrency
            $taskBatches = array_chunk($tasks, $chunkSize);

            foreach ($taskBatches as $batch) {
                Octane::concurrently($batch,1000000);
                usleep(1000000);
            }

            Log::info('Batch processing completed');
        } catch (\Throwable $e) {
            Log::error('An error occurred during batch processing: ' . $e->getMessage());
            throw new ApiValidationException($e->getMessage(), 500);
        }
    }

}
