<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleAssignmentRequest extends FormRequest
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
            "vehicle_id" => "required|exists:vehicles,vehicle_id|string",
            'user_profile_ids' => 'nullable|array',
            'user_profile_ids.*' => 'exists:user_profile,user_profile_id',
        ];
    }
}
