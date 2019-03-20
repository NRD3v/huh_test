<?php

namespace App\Http\Responses;

class SuccessResponse
{
    public static function send($payload)
    {
        return [
            "code" => 200,
            "status" => "success",
            "data" => $payload
        ];
    }
}
