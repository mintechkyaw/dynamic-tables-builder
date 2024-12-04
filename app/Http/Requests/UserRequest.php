<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'role_id' => 'required|string|exists:roles,id',
                'permissions' => 'required|array',
                'permissions.*' => 'required|exists:permissions,id',
                'password' => 'required|password',
            ];
        }

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email:rfc,dns|unique:users,email,except,'.$this->route('user'),
            'role_id' => 'sometimes|string|exists:roles,id',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'sometimes|exists:permissions,id',
        ];
    }
}
