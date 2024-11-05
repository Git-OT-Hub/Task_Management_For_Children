<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'goal' => 'max:1000',
            'icon' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ニックネーム',
            'email' => 'メールアドレス',
            'goal' => '目標設定',
            'icon' => 'アイコン',
        ];
    }
}
