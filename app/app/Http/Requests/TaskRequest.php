<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            "title" => "required|string|max:50",
            "deadline" => "required|date",
            "point" => "required|integer|min:0",
            "body" => "max:1000",
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'deadline' => '期限',
            'point' => 'ポイント',
            'body' => 'メッセージ',
        ];
    }
}
