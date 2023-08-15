<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreAttendanceRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'employee_id' => auth()->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'employee_id' => 'exists:employees,id',
            'type' => 'in:1,2',
            'checkin_longitude' => 'required',
            'checkin_latitude' => 'required',
            'checkin_time' => 'required|date_format:H:i:s',
            'checkin_photo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.exists' => 'Pengguna tidak terdaftar',
            'checkin_longitude.required' => 'Longitude wajib diisi',
            'checkin_latitude.required' => 'Latitude wajib diisi',
            'checkin_time.required' => 'Waktu absen tidak boleh kosong',
            'checkin_time.date_format' => 'Maaf tidak sesuai format',
            'checkin_photo.required' => 'Selfie wajib',
        ];
    }
}
