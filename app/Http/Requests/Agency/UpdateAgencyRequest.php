<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgencyRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama instansi wajib diisi',
            'name.min' => 'Nama instansi minimal 3 kata',
            'name.max' => 'Nama instansi minimal 255 kata',
            'longitude.required' => 'Longitude wajib diisi',
            'longitude.numeric' => 'Longitude hanya boleh angka',
            'latitude.required' => 'Latitude wajib diisi',
            'latitude.numeric' => 'Latitude hanya boleh angka',
        ];
    }
}
