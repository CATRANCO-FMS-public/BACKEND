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
            'end_time' => 'nullable|date|after_or_equal:now', // Validate that end_time is a valid date and in the future
            'dispatch_status' => 'required|in:on_alley,on_road,completed', // Validate dispatch_status
            'terminal_id' => 'required|exists:terminals,terminal_id',
            'vehicle_assignment_id' => 'required|exists:vehicle_assignment,vehicle_assignment_id',
        ];
    }
}
