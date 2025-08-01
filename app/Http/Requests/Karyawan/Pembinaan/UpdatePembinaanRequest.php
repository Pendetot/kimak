<?php

namespace App\Http\Requests\Karyawan\Pembinaan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePembinaanRequest extends FormRequest
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
            'tanggal_pembinaan' => 'sometimes|required|date',
            'catatan' => 'sometimes|required|string',
            'hasil' => 'sometimes|required|string',
        ];
    }
}
