<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'status' => 2,
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
            'type' => 'required|in:1,2,3',
            'explanation' => 'required',
            'file' => 'required|max:2048|mimes:png,jpg,jpeg,pdf',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'in:1,2,3',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Jenis pengajuan Wajib Diisi',
            'type.in' => 'Jenis pengajuan tidak ada dalam daftar',
            'explanation.required' => 'Keterangan pengajuan tidak boleh kosong',
            'file.required' => 'File wajib diupload',
            'file.max' => 'Ukuran file maksimal 2 MB',
            'file.mimes' => 'File yang diupload berupa gambar atau pdf',
            'start_date.required' => 'Tanggal mulai wajib dipilih',
            'start_date.date' => 'Maaf, harus format tanggal',
            'end_date.required' => 'Tanggal selesai wajib dipilih',
            'end_date.date' => 'Maaf, harus format tanggal',
            'end_date.after' => 'Tanggal Selesai tidak boleh kurang dari Tanggal Mulai'
        ];
    }
}
