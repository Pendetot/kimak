<?php

namespace App\Http\Requests\Karyawan\LapDokumen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLapDokumenRequest extends FormRequest
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
            'karyawan_id' => 'sometimes|required|exists:karyawans,id',
            'nama_dokumen' => 'sometimes|required|string|max:255',
            'file_path' => 'sometimes|required|string|max:255',
        ];
    }
}
