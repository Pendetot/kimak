<?php

namespace App\Http\Requests\Karyawan\KPI;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKPIRequest extends FormRequest
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
            'periode' => 'sometimes|required|string|max:255',
            'nilai_kpi' => 'sometimes|required|integer|min:0|max:100',
            'evaluasi' => 'nullable|string',
        ];
    }
}
