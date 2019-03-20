<?php

namespace App\Http\Responses;

class ErrorResponse
{
    public static function send($payload)
    {
        return [
            "code" => 422,
            "status" => "error",
            "data" => $payload
        ];
    }
}
