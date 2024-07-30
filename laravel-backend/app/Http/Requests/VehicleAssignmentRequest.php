<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleAssignmentRequest extends FormRequest
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
            "assignment_date" => "required|date_format:Y-m-d H:i:s",
            "return_date" => "required|date_format:Y-m-d H:i:s|after:assignment_date",
            "user_profile_id" => "required|exists:user_profiles,user_profile_id|integer",
            "vehicle_id" => "required|exists:vehicles,vehicle_id|integer",
            "created_by" => "required|exists:users,user_id|integer",
            "updated_by" => "nullable|exists:users,user_id|integer",
            "deleted_by" => "nullable|exists:users,user_id|integer",
        ];
    }
}
