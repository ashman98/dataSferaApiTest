<?php

namespace App\Interfaces;

use App\Services\AbstractServices\ApiCallAbstract;

interface DataSferaCallApiInterface
{
    /**
     * @return ApiCallAbstract
     */
    public function callApiGet(): ApiCallAbstract;

    /**
     * @param string $endpoint
     * @return ApiCallAbstract
     */
    public function setEndpoint(string $endpoint): ApiCallAbstract;

    /**
     * @return ApiCallAbstract
     */
    public function reset():ApiCallAbstract;

    /**
     * @param array $body
     * @return ApiCallAbstract
     */
    public function setBody(array $body): ApiCallAbstract;

    /**
     * @param array $headers
     * @return ApiCallAbstract
     */
    public function setHeaders(array $headers): ApiCallAbstract;

    /**
     * @param string $token
     * @return ApiCallAbstract
     */
    public function setToken(string $token): ApiCallAbstract;

    /**
     * @return array
     */
    public function getResult(): array;

    /**
     * @param int $limit
     * @return ApiCallAbstract
     */
    public function setLimit(int $limit): ApiCallAbstract;
}
