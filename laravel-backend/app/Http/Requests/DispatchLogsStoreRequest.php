<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispatchLogsStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'vehicle_assignment_ids' => 'required|array',
            'vehicle_assignment_ids.*' => 'exists:vehicle_assignment,vehicle_assignment_id',
            'fuel_logs_id' => 'required|exists:fuel_logs,fuel_logs_id',
        ];
    }
}

