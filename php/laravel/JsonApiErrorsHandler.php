<?php

namespace App\Exceptions\Handlers;

use Illuminate\Validation\ValidationException;

trait JsonApiErrorsHandler
{
    protected function invalidJson($request, ValidationException $exception)
    {
        $response = [
            'errors' => [],
        ];

        foreach ($exception->errors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $response['errors'][] = [
                    'attribute' => $attribute,
                    'title' => $exception->getMessage(),
                    'detail' => $error,
                ];
            }
        }

        return response()->json($response, $exception->status);
    }
}
