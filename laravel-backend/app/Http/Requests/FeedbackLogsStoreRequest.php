<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackLogsStoreRequest extends FormRequest
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
            'phone_number' => 'required|string|max:20',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
            'vehicle_id' => 'required|exists:vehicles,vehicle_id',
        ];
    }
}
