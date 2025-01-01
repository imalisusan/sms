<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MakePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'term_id' => 'required|exists:terms,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'The student ID field is required.',
            'student_id.exists' => 'The selected student ID does not exist.',
            'term_id.required' => 'The term ID field is required.',
            'term_id.exists' => 'The selected term ID does not exist.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a numeric value.',
            'amount.min' => 'The amount must be at least 1.',
            'payment_method.required' => 'The payment method field is required.',
            'payment_method.string' => 'The payment method must be a string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422));
    }
}
