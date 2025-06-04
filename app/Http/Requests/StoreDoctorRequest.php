<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:users,email',
            'workplace'              => 'nullable|string|max:255',
            'specialty'              => 'required|string|max:255',
            'additional_information' => 'nullable|string',
            'role'                  => 'required|in:User,Doctor,Administrator',
            // Поле "password-send" можна не зберігати, тому валідацію для нього можна пропустити
        ];
    }
}
