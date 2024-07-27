<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $user_id = $this->route("user");
        return [
            "name" =>"sometimes|string",
            "email" =>"sometimes|email|unique:users,email,{$user_id}",
            "password" =>"nullable|min:8",
            "conipassword" =>"same:password",
            "phone" =>"sometimes|numeric|regex:/^[0-9]{11}$/",
            "gender" =>"sometimes|in:male,female",
            "image" =>"sometimes|mimes:png,jpg,jpeg|max:1024",
        ];
    }
}
