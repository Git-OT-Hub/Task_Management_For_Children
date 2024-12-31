<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RewardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "point" => "required|integer|min:0",
            "reward" => "required|string|max:50",
        ];
    }

    public function attributes()
    {
        return [
            'point' => 'ポイント',
            'reward' => '報酬'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->ajax()) {
            $response = [
                'status' => Response::HTTP_BAD_REQUEST,
                'errors' => $validator->errors()->toArray(),
            ];
            
            throw new HttpResponseException(
                response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    
        parent::failedValidation($validator);
    }
}
