<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

trait ApiHelper {

    public function sendResponse($result, $message)
    {
        $this->setAccessControlHeaders();

        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,

        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,

        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function setAccessControlHeaders() 
    {
        @header('Access-Control-Allow-Origin: *');
        @header('Access-Control-Allow-Credentials: true');
        @header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
        @header('Vary: Origin');
        @header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

}

