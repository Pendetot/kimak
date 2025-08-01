<?php

namespace App\Http\Requests\Karyawan\Pembinaan;

use Illuminate\Foundation\Http\FormRequest;

class StorePembinaanRequest extends FormRequest
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
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal_pembinaan' => 'required|date',
            'catatan' => 'required|string',
            'hasil' => 'required|string',
        ];
    }
}
