<?php

namespace App\Services;

use App\Exceptions\ApiValidationException;
use App\Interfaces\DataSferaCallApiInterface;
use App\Interfaces\SaveExternalDataInterface;
use App\Interfaces\SaveIntegrationDataInterface;
use App\Jobs\IntegrationProcess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaveExternalDataService implements SaveExternalDataInterface
{
    /** @var DataSferaCallApiInterface */
    private DataSferaCallApiInterface $dataSferaCallApiService;
    /** @var string  */
    private string $endpoint = '';
    /** @var string  */
    private string $token = '';
    /** @var array  */
    private array $body = [];
    /** @var int  */
    private int $page = 1;
    /** @var array  */
    private array $callResults = [];

    public function __construct(
        DataSferaCallApiInterface $dataSferaCallApiService,
    )
    {
        $this->dataSferaCallApiService = $dataSferaCallApiService;
    }


    public function setEndpoint(string $endpoint): SaveExternalDataService
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function setToken(string $token): SaveExternalDataService
    {
        $this->token = $token;
        return $this;
    }

    public function setBody(array $body): SaveExternalDataService
    {
        $this->body = $body;
        return $this;
    }

    public function setPage(int $page): SaveExternalDataService
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @throws ApiValidationException
     */
    public function save(SaveIntegrationDataInterface $saveDataService): void
    {
        try {
            $this->dataSferaCallApiService
                ->reset()
                ->setEndpoint($this->endpoint)
                ->setToken($this->token)
                ->setBody(array_merge($this->body, ['page' => $this->page]));

            $this->callResults = $this->dataSferaCallApiService->callApiGet()->getResult();

            if (empty($this->callResults['data'])) {
                Log::channel("integration")->warning('Failed to fetch data: No data on page ' . $this->page);
                throw new ApiValidationException('Failed to fetch data: No data on page ' . $this->page, 500);
            }
            if (!isset($this->callResults['meta']['last_page'])) {
                Log::channel("integration")->error('Failed to fetch data: No pagination info ' . $this->page);
                throw new ApiValidationException('Failed to fetch data: No pagination info', 500);
            }

            $chunks = array_chunk($this->callResults['data'], 100);
            foreach ($chunks as $chunk) {
                try {
                    DB::beginTransaction();
                    $saveDataService->reset()->setDataList($chunk)->save();
                    DB::commit();
                    Log::channel("integration")->info("Success inserted data for page {$this->page} from endpoint {$this->endpoint}");
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::channel("integration")->warning("Error while inserting data for page {$this->page}: " . $e->getMessage());
                }
            }

            if ($this->page < $this->callResults['meta']['last_page']) {
                IntegrationProcess::dispatch(
                    $this->endpoint,
                    $this->token,
                    $this->body,
                    $this->page + 1,
                    $saveDataService
                )->delay(now()->addSeconds(1));
            }
        } catch (\Throwable $e) {
            Log::channel("integration")->error("Error {$this->page}: " . $e->getMessage());
            throw new ApiValidationException($e->getMessage(), 500);
        }

    }

    /**
     * @return $this
     */
    public function reset(): SaveExternalDataService
    {
        unset($this->body);
        unset($this->page);
        unset($this->token);
        unset($this->endpoint);
        unset($this->callResults);

        $this->body = [];
        $this->page = 1;
        $this->token = '';
        $this->endpoint = '';
        $this->callResults = [];

        return $this;
    }


}
