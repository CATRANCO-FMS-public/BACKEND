<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackerVehicleMappingRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if you want to limit authorization checks
    }

    public function rules()
    {
        return [
            'device_name' => 'required|string|max:255',
            'tracker_ident' => 'nullable|unique:tracker_vehicle_mapping,tracker_ident,' . $this->route('tracker_vehicle_mapping'),
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
        ];
    }
}
