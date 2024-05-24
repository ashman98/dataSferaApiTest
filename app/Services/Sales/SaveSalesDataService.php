<?php

namespace App\Services\Sales;

use App\Exceptions\ApiValidationException;
use App\Exceptions\CustomApiException;
use App\Interfaces\DataSferaCallApiInterface;
use App\Interfaces\Sales\SaveSalesDataInterface;
use App\Services\AbstractServices\SaveIntegrationDataAbstract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Octane\Facades\Octane;

class SaveSalesDataService extends SaveIntegrationDataAbstract implements SaveSalesDataInterface
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
    public function save(string $endpoint, string $token, array $body):void
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
                                    'g_number' => $item['g_number'],
                                    'date' => $item['date'],
                                    'last_change_date' => $item['last_change_date'],
                                    'supplier_article' => $item['supplier_article'],
                                    'tech_size' => $item['tech_size'],
                                    'barcode' => $item['barcode'],
                                    'total_price' => $item['total_price'],
                                    'discount_percent' => $item['discount_percent'],
                                    'is_supply' => $item['is_supply'],
                                    'is_realization' => $item['is_realization'],
                                    'promo_code_discount' => $item['promo_code_discount'],
                                    'warehouse_name' => $item['warehouse_name'],
                                    'country_name' => $item['country_name'],
                                    'oblast_okrug_name' => $item['oblast_okrug_name'],
                                    'region_name' => $item['region_name'],
                                    'income_id' => $item['income_id'],
                                    'sale_id' => $item['sale_id'],
                                    'odid' => $item['odid'],
                                    'spp' => $item['spp'],
                                    'for_pay' => $item['for_pay'],
                                    'finished_price' => $item['finished_price'],
                                    'price_with_disc' => $item['price_with_disc'],
                                    'nm_id' => $item['nm_id'],
                                    'subject' => $item['subject'],
                                    'category' => $item['category'],
                                    'brand' => $item['brand'],
                                    'is_storno' => $item['is_storno'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }
                        }

                        if (!empty($dataToInsert)) {
                            DB::table('sales')->insert($dataToInsert);
                            Log::info("Inserted data for page {$page}", ['count' => count($dataToInsert)]);
                            return;
                        }

                        Log::warning("No data to insert for page {$page}");
                        return;
                    });
                };
            }, range(1, $pageCount));

            $chunkSize = 100;
            $taskBatches = array_chunk($tasks, $chunkSize);

            foreach ($taskBatches as $batch) {
                Octane::concurrently($batch, 1000000);
                usleep(500000);
            }

            Log::info('Batch processing completed');
        } catch (\Throwable $e) {
            throw new ApiValidationException($e->getMessage(), 500);
        }
    }

}
