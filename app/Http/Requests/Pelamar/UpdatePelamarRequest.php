<?php

namespace App\Http\Requests\Pelamar;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelamarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:pelamars,email,' . $this->route('pelamar')->id,
            'telepon' => 'sometimes|required|string|max:20',
            'alamat' => 'sometimes|required|string',
            'pendidikan_terakhir' => 'sometimes|required|string|max:255',
            'pengalaman_kerja' => 'nullable|string',
            'posisi_dilamar' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|string|in:pending,diterima,ditolak',
        ];
    }
}
