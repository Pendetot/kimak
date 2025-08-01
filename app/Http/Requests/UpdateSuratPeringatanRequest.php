<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuratPeringatanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'karyawan_id' => ['required', 'exists:users,id'],
            'jenis_sp' => ['required', 'string'],
            'tanggal_sp' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
