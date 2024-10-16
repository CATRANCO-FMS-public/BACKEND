<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispatchStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Set to true if you want all authenticated users to make this request
        // Otherwise, add your own authorization logic
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
            'end_time' => 'nullable|date|after:start_time',
            'fuel_logs_id' => 'required|exists:fuel_logs,fuel_logs_id',
            'vehicle_assignment_id' => 'required|exists:vehicle_assignment,vehicle_assignment_id',
        ];
    }
}
