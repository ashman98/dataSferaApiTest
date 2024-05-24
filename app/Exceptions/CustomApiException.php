<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomApiException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct($message = "Something went wrong.", $statusCode = 500)
    {
        parent::__construct($message, $statusCode);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->message,
        ], $this->statusCode);
    }
}
