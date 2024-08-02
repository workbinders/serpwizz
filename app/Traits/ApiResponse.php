<?php

namespace App\Traits;

trait ApiResponse
{
    public function sendResponse($message = '', $data = null)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data ?? [],
        ]);
    }

    public function sendError($message = 'error', $file = '', $error = [], $status = 200)
    {
        return response()->json([
            'status'   => false,
            'message'  => $message,
            'file'     => $file,
            'error'    => $error ?? [],
        ], $status);
    }
}
