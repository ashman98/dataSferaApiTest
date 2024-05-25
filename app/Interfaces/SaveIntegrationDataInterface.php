<?php

namespace App\Interfaces;

use App\Services\AbstractServices\SaveIntegrationDataAbstract;

interface SaveIntegrationDataInterface
{
    /**
     * @return void
     */
    public function save(): void;

    /**
     * @param array $dataList
     * @return SaveIntegrationDataAbstract
     */
    public function setDataList(array $dataList): SaveIntegrationDataAbstract;

    /**
     * @return int
     */
    public function getResultCount(): int;

    /**
     * @return SaveIntegrationDataAbstract
     */
    public function reset(): SaveIntegrationDataAbstract;
}
