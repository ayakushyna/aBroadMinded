<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:female,male,undefined',
            'birthday' => 'nullable|date',
            'active' => 'required|boolean',
            'city_id' => 'nullable|integer|exists:App\Models\City,id',
            'user_id' => 'required|integer|exists:App\Models\User,id',
        ];
    }
}
