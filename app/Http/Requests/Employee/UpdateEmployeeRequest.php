<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
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
            'agency_id' => ['required', 'exists:\App\Models\Agency,id'],
            'position_id' => ['required', 'exists:\App\Models\Position,id'],
            'name' => ['required', 'min:3', 'max:255'],
            'nip' => ['required', 'min:3', 'max:255', 'unique:employees,nip,' . $this->employee->id],
            'email' => ['required', 'email', 'unique:employees,email,'  . $this->employee->id],
            'role' => ['required', 'exists:roles,id'],
            'password' =>  [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages()
    {
        return [
            'agency_id.required' => 'Instansi wajib dipilih',
            'agency_id.exists' => 'Instansi tidak ada dalam daftar',
            'position_id.required' => 'Jabatan wajib dipilih',
            'position_id.exists' => 'Jabatan tidak ada dalam daftar',
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 huruf',
            'name.max' => 'Nama maksimal 255 huruf',
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.min' => 'NIP minimal 3 huruf',
            'nip.max' => 'NIP maksimal 255 huruf',
            'nip.unique' => 'NIP sudah digunakan silahkan pilih yang lain',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Diisi dengan alamat email yang valid',
            'email.unique' => 'Email sudah digunakan silahkan pilih yang lain',
            'role.required' => 'Role tidak boleh kosong',
            'role.exists' => 'Role tidak ada dalam daftar',
            'password.required' => 'Password Wajib Diisi',
            'password.confirmed' => 'Password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
            'status.required' => 'Status Wajib Dipilih',
            'status.in' => 'Status tidak ada dalam daftar',
        ];
    }
}
