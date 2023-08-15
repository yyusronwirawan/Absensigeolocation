<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
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
            'type' => 'in:1,2',
            'checkin_longitude' => 'required|numeric',
            'checkin_latitude' => 'required|numeric',
            'checkout_longitude' => 'nullable|numeric',
            'checkout_latitude' => 'nullable|numeric',
            'checkin_time' => 'required|date_format:H:i:s',
            'checkout_time' => 'nullable|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'type.in' => 'Jenis Absen tidak ada dalam daftar',
            'checkin_longitude.numeric' => 'Longitude absen masuk tidak sesuai format',
            'checkin_latitude.numeric' => 'Latitude absen masuk tidak sesuai format',
            'checkout_latitude.numeric' => 'Longitude absen pulang tidak sesuai format',
            'checkout_longitude.numeric' => 'Latitude absen pulang tidak sesuai format',
            'checkin_time.date_format' => 'Maaf, jam masuk tidak sesuai format',
            'checkout_time.date_format' => 'Maaf, jam pulang tidak sesuai format',
        ];
    }
}
