<?php

namespace App\Http\Requests\Period;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdatePeriodRequest extends FormRequest
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'explanation' => 'required|min:3|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'start_time.required' => 'Jam Mulai tidak boleh kosong',
            'start_time.date_format' => 'Maaf tidak sesuai format',
            'end_time.required' => 'Jam Selesai tidak boleh kosong',
            'end_time.date_format' => 'Maaf tidak sesuai format',
            'end_time.after' => 'Jam Selesai tidak boleh kurang dari Jam Mulai',
            'explanation.required' => 'Keterangan wajib diisi',
            'explanation.min' => 'Keterangan minimal 3 kata',
            'explanation.max' => 'Keterangan minimal 255 kata',
        ];
    }
}
