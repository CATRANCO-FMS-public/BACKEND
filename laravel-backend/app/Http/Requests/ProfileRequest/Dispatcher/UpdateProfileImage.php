<?php

namespace App\Http\Requests\ProfileRequest\Dispatcher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileImage extends FormRequest
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
            'user_profile_image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
