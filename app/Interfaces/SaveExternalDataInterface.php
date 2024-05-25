<?php

namespace App\Interfaces;

use App\Services\SaveExternalDataService;

interface SaveExternalDataInterface
{
    /**
     * @param SaveIntegrationDataInterface $saveDataService
     * @return void
     */
    public function save(SaveIntegrationDataInterface $saveDataService): void;

    /**
     * @return SaveExternalDataService
     */
    public function reset(): SaveExternalDataService;

    /**
     * @param string $endpoint
     * @return SaveExternalDataService
     */

    public function setEndpoint(string $endpoint): SaveExternalDataService;

    /**
     * @param string $token
     * @return SaveExternalDataService
     */
    public function setToken(string $token): SaveExternalDataService;

    /**
     * @param array $body
     * @return SaveExternalDataService
     */
    public function setBody(array $body): SaveExternalDataService;

    /**
     * @param int $page
     * @return SaveExternalDataService
     */
    public function setPage(int $page): SaveExternalDataService;
}
