<?php

namespace App\Services;

use App\Exceptions\ApiValidationException;
use App\Interfaces\DataSferaCallApiInterface;
use Illuminate\Support\Facades\Http;
use Laravel\Octane\Facades\Octane;

class SaveExternalData
{
    /** @var DataSferaCallApiInterface */
    private DataSferaCallApiInterface $dataSferaCallApiService;
    public function __construct(DataSferaCallApiInterface $dataSferaCallApiService)
    {
        $this->dataSferaCallApiService = $dataSferaCallApiService;
    }

    /**
     * @throws ApiValidationException
     */
    public function save(string $endpoint,string $token, array $body)
    {


    }

}
