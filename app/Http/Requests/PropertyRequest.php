<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'price' => 'required',
            'host_type' => 'required|in:entire place,private room,shared room',
            'air_condition' => 'required|boolean',
            'children' => 'required|boolean',
            'hair_dryer' => 'required|boolean',
            'parties' => 'required|boolean',
            'pets' => 'required|boolean',
            'smoking' => 'required|boolean',
            'tv' => 'required|boolean',
            'wifi' => 'required|boolean',
            'max_bedrooms' => 'required|int',
            'max_beds' => 'required|int',
            'max_guests' => 'required|int',
            'active' => 'required|boolean',
            'profile_id' => 'required|integer|exists:App\Models\Profile,id',
            'city_id' => 'required|integer|exists:App\Models\City,id',
            'property_type_id' => 'required|integer|exists:App\Models\PropertyType,id',
        ];
    }
}
