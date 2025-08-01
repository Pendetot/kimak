<?php

namespace App\Http\Requests\Keuangan\Hutang;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHutangKaryawanRequest extends FormRequest
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
            'karyawan_id' => 'sometimes|required|exists:users,id',
            'jumlah_hutang' => 'sometimes|required|numeric|min:0',
            'tanggal_hutang' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:lunas,belum_lunas',
        ];
    }
}
