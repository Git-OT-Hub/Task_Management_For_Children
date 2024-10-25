<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoomRequest extends FormRequest
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
            "room_name" => "required|max:50",
            "user_name" => "required|exists:users,name",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->ajax()) {
            $response = [
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ];
            
            throw new HttpResponseException(
                response()->json($response, 422)
            );
        }
    
        parent::failedValidation($validator);
    }
}
