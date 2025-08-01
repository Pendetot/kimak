<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'nik' => ['required', 'string', 'max:255', Rule::unique('karyawans')->ignore($this->karyawan->id)],
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'jabatan' => 'required|string|max:255',
            'penempatan' => 'required|string|max:255',
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }
}
