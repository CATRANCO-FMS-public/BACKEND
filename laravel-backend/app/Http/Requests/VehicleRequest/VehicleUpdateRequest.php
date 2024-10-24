<?php

namespace App\Http\Requests\VehicleRequest;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'vehicle_id' => 'nullable|string|max:10|unique:vehicles,vehicle_id',
            'or_id' => 'nullable|string|max:50',
            'cr_id' => 'nullable|string|max:50',
            'plate_number' => 'nullable|string|max:50|unique:vehicles,plate_number',
            'engine_number' => 'nullable|string|max:50',
            'chasis_number' => 'nullable|string|max:50',
            'third_pli' => 'nullable|string|max:20',
            'third_pli_policy_no' => 'nullable|string|max:50',
            'third_pli_validity' => 'nullable|date',
            'ci' => 'nullable|string|max:50',
            'ci_validity' => 'nullable|date',
            'date_purchased' => 'nullable|date',
            'supplier' => 'nullable|string|max:20',
        ];
    }
}
