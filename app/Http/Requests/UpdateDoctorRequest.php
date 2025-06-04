<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
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
    public function rules()
    {
        // Получаем идентификатор врача из параметров маршрута.
        // Предполагается, что используется Route Model Binding с параметром {doctor}.
        $doctorId = $this->route('doctor')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                // Правило уникальности email, исключая текущую запись
                Rule::unique('users')->ignore($doctorId),
            ],
            'workplace' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'additional_information' => 'nullable|string',
            // Поле "password_send" ожидает значение "immediately" или "do_not_send"
            'password_send' => 'nullable|in:immediately,do_not_send',
            'role'                  => 'required|in:User,Doctor,Administrator',
        ];
    }
}
