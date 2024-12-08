<?php

namespace App\Http\Requests\MaintenanceSchedulingRequest;

use Illuminate\Foundation\Http\FormRequest;

class ToggleMaintenanceStatusRequest extends FormRequest
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
            'maintenance_complete_proof' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
