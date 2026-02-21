<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    public function success($data = [], string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

    public function error(string $message, int $code = 400, $errors = []): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'message'   => $message,
            'errors'    => $errors
        ], $code);
    }
}
