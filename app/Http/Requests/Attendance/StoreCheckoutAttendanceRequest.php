<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutAttendanceRequest extends FormRequest
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
            'checkout_longitude' => 'required',
            'checkout_latitude' => 'required',
            'checkout_time' => 'required|date_format:H:i:s',
            'checkout_photo' => 'required',
        ];
    }
}
