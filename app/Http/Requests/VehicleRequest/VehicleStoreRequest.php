<?php

namespace App\Http\Requests\VehicleRequest;

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
            'vehicle_id' => 'required|string|max:10|unique:vehicles,vehicle_id',
            'or_id' => 'required|string|max:50',
            'cr_id' => 'required|string|max:50',
            'plate_number' => 'required|string|max:50|unique:vehicles,plate_number',
            'engine_number' => 'required|string|max:50',
            'chasis_number' => 'required|string|max:50',
            'third_pli' => 'required|string|max:20',
            'third_pli_policy_no' => 'required|string|max:50',
            'third_pli_validity' => 'required|date',
            'ci' => 'required|string|max:50',
            'ci_validity' => 'required|date',
            'date_purchased' => 'required|date',
            'supplier' => 'required|string|max:20',
            'route' => 'required|in:Cogon,Canitoan,Silver Creek',
        ];
    }
}
