<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as StatusCode;


abstract class Controller
{
    public function apiResponseStandard(array|object|null $data = null, string $message = '', bool $success = true, int|null $status = null, array $errors = []): JsonResponse
    {
        $data = (array)$data;
        $status = $status ?? StatusCode::HTTP_OK/*200*/
        ;

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ], $status);
    }
}
