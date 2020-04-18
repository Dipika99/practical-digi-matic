<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'min:8', 'max:150'],
            'phone_number' => ['required', 'string', 'min:8', 'max:20'],
            'zip_code' => ['required', 'string', 'min:5', 'max:9'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,jpeg','max:2048'],
            'roles' => ['required', 'array'],

        ];
    }
}
