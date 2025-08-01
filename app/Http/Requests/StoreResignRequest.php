<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResignRequest extends FormRequest
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
            'tanggal_pengajuan' => 'required|date',
            'tanggal_efektif' => 'required|date|after_or_equal:tanggal_pengajuan',
            'alasan' => 'required|string',
            'status' => ['required', Rule::in(['pending', 'disetujui', 'ditolak'])],
        ];
    }
}