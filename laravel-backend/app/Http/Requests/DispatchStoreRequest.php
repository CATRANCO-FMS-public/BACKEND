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
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time', // Ensure end_time is after start_time
            'dispatch_status' => 'required|in:in_progress,completed,cancelled',
            'dispatch_logs_id' => 'required|exists:dispatch_logs,dispatch_logs_id',
        ];
    }
}