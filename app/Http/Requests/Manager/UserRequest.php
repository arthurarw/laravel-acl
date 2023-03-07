<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('user')->id,
        ];

        if (!empty($this->request->get('password'))) {
            $validation['password'] = 'sometimes|string|min:8|confirmed';
        }

        if (!empty($this->request->get('role'))) {
            $validation['role'] = 'required|exists:roles,id';
        }

        return $validation;
    }
}
