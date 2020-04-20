<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'adults' => 'required|integer',
            'children' => 'required|integer',
            'price' => 'required|integer',
            'status' => 'required|in:cancelled,awaiting,confirmed',
            'profile_id' => 'required|integer|exists:App\Models\Profile,id',
            'property_id' => 'required|integer|exists:App\Models\Property,id',
        ];
    }
}
