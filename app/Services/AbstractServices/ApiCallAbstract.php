<?php

namespace App\Services\AbstractServices;

use App\Exceptions\ApiValidationException;

abstract class ApiCallAbstract
{
    /** @var string*/
    protected string $token = '';
    /** @var string */
    protected string $host = '';
    /** @var array */
    protected array $headers = [];
    /** @var string */
    protected string $endpoint = '';
    /** @var int */
    protected int $method = 1;
    /** @var array */
    protected array $body = [];
    /** @var array */
    protected array $result = [];
    /** @var int */
    protected int $limit = 500;

    /**
     * @throws ApiValidationException
     */
    public function __construct()
    {
        $host = env('API_HOST');
        if (empty($host)) {
            throw new ApiValidationException('Api host is missing');
        }
        $this->host = $host;
    }


    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint(string $endpoint): ApiCallAbstract
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function setBody(array $body): ApiCallAbstract
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): ApiCallAbstract
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): ApiCallAbstract
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit): ApiCallAbstract
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return array
     */
    final public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return void
     * @throws ApiValidationException
     */
    protected function validate(): void
    {
        if (empty($this->endpoint)){
            throw new ApiValidationException('Endpoint host is missing');
        }
    }

    /**
     * @return ApiCallAbstract
     */
    public function reset(): ApiCallAbstract
    {
        unset($this->token);
        unset($this->headers);
        unset($this->endpoint);
        unset($this->method);
        unset($this->body);
        unset($this->result);

        $this->token = '';
        $this->headers = [];
        $this->endpoint = '';
        $this->body = [];
        $this->result = [];
        return $this;
    }

}
