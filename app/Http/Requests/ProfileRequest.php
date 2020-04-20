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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nickname' => 'required|string|unique:profiles|max:255',
            'gender' => 'required|in:female,male',
            'birthday' => 'required|date',
            'active' => 'required|boolean',
            'city_id' => 'required|integer|exists:App\Models\City,id',
        ];
    }
}
