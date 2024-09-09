<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($code, $data = null, $message = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    protected function errorResponse($code, $message = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}
