<?php

namespace App\Interfaces\Stocks;

use App\Services\AbstractServices\SaveIntegrationDataAbstract;

interface SaveStocksDataInterface
{
    /**
     * @return void
     */
    public function save():void;

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
