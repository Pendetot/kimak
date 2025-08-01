<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMutasiRequest extends FormRequest
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
            'karyawan_id' => 'required|exists:users,id',
            'jabatan_lama' => 'required|string|max:255',
            'jabatan_baru' => 'required|string|max:255',
            'alasan' => 'required|string',
            'tanggal_mutasi' => 'required|date',
        ];
    }
}