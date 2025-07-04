<?php

class ResponseService {

    public static function success_response( int $code = 200 , $payload ) {
        
        return json_encode([
            "status" => $code,
            "payload" => $payload
        ]);
    }

    public static function error_response( int $code = 500 , $message ) {
        return json_encode([
            "status" => $code,
            "error" => $message
        ]);
    }
}
