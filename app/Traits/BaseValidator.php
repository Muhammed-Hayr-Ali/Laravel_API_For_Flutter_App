<?php

namespace App\Traits;

trait  BaseValidator
{
    public function sendResponses($title = "Success", $message,  $result = null)
    {
        $response = [
            'status' => true,
            'title' => $title,
            'message' => $message,
        ];
        if (!empty($result)) {
            $response['data'] = $result;
        }
        return response()->json($response, 200);
    }


    public function sendError($title = "Error", $ErrorMessage = 'Unknown error', $code = 404)
    {
        $response = [
            'status' => false,
            'title' => $title,
            'message' => $ErrorMessage,
        ];

        return response()->json($response, $code);
    }
}
