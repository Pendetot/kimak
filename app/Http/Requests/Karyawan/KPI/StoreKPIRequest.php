<?php

namespace App\Http\Requests\Karyawan\KPI;

use Illuminate\Foundation\Http\FormRequest;

class StoreKPIRequest extends FormRequest
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
            'periode' => 'required|string|max:255',
            'nilai_kpi' => 'required|integer|min:0|max:100',
            'evaluasi' => 'nullable|string',
        ];
    }
}
