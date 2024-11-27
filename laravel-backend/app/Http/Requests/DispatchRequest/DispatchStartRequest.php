<?php

namespace App\Http\Requests\DispatchRequest;

use Illuminate\Foundation\Http\FormRequest;

class DispatchStartRequest extends FormRequest
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
            'terminal_id' => 'required|exists:terminals,terminal_id',
            'vehicle_assignment_id' => 'required|exists:vehicle_assignment,vehicle_assignment_id',
        ];
    }
}