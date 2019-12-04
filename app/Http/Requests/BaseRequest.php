<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Contracts\Validation\Validator;

abstract class BaseRequest extends FormRequest {

    public function response(array $errors) {
        return \ResponseApi::respond([], 406, $errors, []);
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(\ResponseApi::respond([], 406, $validator->errors(), []));
    }

}
