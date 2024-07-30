<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
            'vehicle_type' => 'required|string|max:50',
            'model' => 'required|string|max:100',
            'purchase_cost' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate',
            'capacity' => 'required|integer|min:1',
            'current_mileage' => 'required|integer|min:0',
            'vehicle_status' => 'required|in:idle,moving,maintenance,decommissioned',
        ];
    }
}
