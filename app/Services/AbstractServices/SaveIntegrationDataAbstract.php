<?php

namespace App\Services\AbstractServices;

use Exception;

abstract class SaveIntegrationDataAbstract
{
    /** @var int */
    protected int $resultCount = 0;

    /** @var array */
    protected array $dataList = [];

    /** @var array */
    protected array $dataToInsert = [];

    public function setDataList(array $dataList): SaveIntegrationDataAbstract
    {
        $this->dataList = $dataList;
        return $this;
    }

    /**
     * @return int
     */
    public function getResultCount(): int
    {
        return $this->resultCount;
    }

    /**
     * @return $this
     */
    public function reset(): SaveIntegrationDataAbstract
    {
        unset($this->dataToInsert);
        unset($this->dataList);

        $this->dataToInsert = [];
        $this->dataList = [];

        return $this;
    }

    /**
     * @throws Exception
     */
    protected function validate(): void
    {
        if(empty($this->dataList)){
            throw new Exception('data to insert not found');
        }
    }

}
