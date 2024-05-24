<?php

namespace App\Interfaces\Orders;

interface SaveOrdersDataInterface
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
