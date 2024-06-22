<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait JsonResponseTrait
{
    public function response(array $data, $status_code = Response::HTTP_OK, $headers = [], $options = 0): JsonResponse
    {
        return response()->json($data, $status_code, $headers, $options);
    }

    public function success($message = null, $data = null, int $status_code = Response::HTTP_OK, $headers = [], $options = 0): JsonResponse
    {
        $response_data = [
            'status' => true,
            'message' => $message,
            'data' => $data,
        ];

        return $this->response($response_data, $status_code, $headers, $options);
    }

    public function successPaginate($message = null, $data = null, int $status_code = Response::HTTP_OK, $headers = [], $options = 0): JsonResponse
    {
        $response_data = [];
        $response_data['status'] = true;
        $response_data['message'] = $message;

        $response_data = $response_data + $data;

        return $this->response($response_data, $status_code, $headers, $options);
    }

    public function failed($message = null, int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR, $errors = null, $headers = [], $options = 0): JsonResponse
    {
        $response_data = [
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return $this->response($response_data, $status_code, $headers, $options);
    }
}
