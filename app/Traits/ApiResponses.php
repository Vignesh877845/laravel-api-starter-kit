<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    public function success($data, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

    public function error($data = null, string $message, int $code = 400){
        return response()->json([
            'success'   => false,
            'message'   => $message,
            'data'      => $data
        ], $code);
    }
}
