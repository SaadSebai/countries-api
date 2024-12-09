<?php

namespace App\Exceptions\Responses;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;

class ThrottleExceptionResponse
{
    public function __invoke(ThrottleRequestsException $e): JsonResponse
    {
        return response()->json([
            'message' => __('exceptions.throttle'),
            'retry_after' => $e->getHeaders()['Retry-After'] ?? null,
        ], 429);
    }
}
