<?php

namespace App\Http\Requests\ProfileRequest\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnProfile extends FormRequest
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
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:1',
            'license_number' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:Male,Female', 
            'contact_number' => 'required|string|max:20',
            'contact_person' => 'nullable|string|max:255',
            'contact_person_number' => 'nullable|string|max:20',
            'user_profile_image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
