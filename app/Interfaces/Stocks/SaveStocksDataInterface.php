<?php

namespace App\Interfaces\Stocks;

interface SaveStocksDataInterface
{
    /**
     * @param string $endpoint
     * @param string $token
     * @param array $body
     * @return void
     */
    public function save(string $endpoint,string $token, array $body):void;

    /**
     * @return int
     */
    public function getResultCount(): int;
}
