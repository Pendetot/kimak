<?php

namespace App\Http\Requests\HRD\Cuti;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCutiRequest extends FormRequest
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
            'tanggal_mulai' => 'sometimes|required|date',
            'tanggal_selesai' => 'sometimes|required|date|after_or_equal:tanggal_mulai',
            'jenis_cuti' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:pending,approved,rejected',
        ];
    }
}
