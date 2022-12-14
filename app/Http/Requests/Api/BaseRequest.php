<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = collect();
        foreach ($validator->errors()->all() as $key => $error) {
            $errors->push([
                'error_name'=>$validator->errors()->keys()[$key] ?? "Error",
                'error_descr' => $error
            ]);
        }

        $response = new Response([
            'status' => false,
            'errors' => $errors
        ], 422, [
            'CARD_LK-message'=>$validator->errors()->first()
        ]);
        throw new ValidationException($validator, $response);
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'You\'re not authorized to do this request',
        ], 403));
    }
}
