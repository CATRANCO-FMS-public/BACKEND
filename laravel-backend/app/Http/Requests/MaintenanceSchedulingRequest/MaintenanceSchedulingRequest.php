<?php

namespace App\Http\Requests\MaintenanceSchedulingRequest;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceSchedulingRequest extends FormRequest
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
            'maintenance_type' => 'required|in:oil_change,tire_rotation,brake_inspection,engine_check,transmission_service',
            'maintenance_cost' => 'required|numeric|min:0',
            'maintenance_date' => 'required|date',
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
            'mechanic_company' => 'required|string|max:100',
            'mechanic_company_address' => 'required|string|max:255',
        ];
    }
}
