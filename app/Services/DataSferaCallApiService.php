<?php

namespace App\Services;

use App\Exceptions\ApiValidationException;
use App\Exceptions\CustomApiException;
use App\Interfaces\DataSferaCallApiInterface;
use App\Services\AbstractServices\ApiCallAbstract;
use Illuminate\Support\Facades\Http;

class DataSferaCallApiService extends ApiCallAbstract implements DataSferaCallApiInterface
{

//TODO add another method example put/post...
//TODO and make post/put responses whit Octane...
//TODO AND MORE WORKS :))) BUT I DONT HAVE MANY TIME :((

    /**
     * @return ApiCallAbstract
     * @throws ApiValidationException
     * @throws CustomApiException
     */
    public function callApiGet(): ApiCallAbstract
    {
        $this->validate();
        $this->body['limit'] = $this->limit;
        if (isset($this->token)){
            $this->body['key'] = $this->token;
        }
        $response = Http::get($this->host.'/'.$this->endpoint, $this->body);
        if (!$response->successful()) {
            throw new CustomApiException($response->status());
        }
        $this->result = $response->json();
        return $this;
    }

    /**
     * @param $resultData
     * @return array
     */
    private function parseResultData($resultData): array
    {
        return $resultData;
    }

}
