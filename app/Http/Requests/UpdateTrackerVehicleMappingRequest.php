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
            'tracker_ident' => 'required|max:50|unique:tracker_vehicle_mapping,tracker_ident,' . $this->route('id'),
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
        ];
    }
}
