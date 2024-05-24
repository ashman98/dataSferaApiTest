<?php

namespace App\Services\AbstractServices;

use App\Interfaces\DataSferaCallApiInterface;

abstract class SaveIntegrationDataAbstract
{
    /** @var DataSferaCallApiInterface */
    protected DataSferaCallApiInterface $dataSferaCallApiService;
    public function __construct(DataSferaCallApiInterface $dataSferaCallApiService)
    {
        $this->dataSferaCallApiService = $dataSferaCallApiService;
    }

    /**
     * @var int
     */
    protected $resultCount = 0;

    /**
     * @return int
     */
    public function getResultCount(): int
    {
        return $this->resultCount;
    }

}
