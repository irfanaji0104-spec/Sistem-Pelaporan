<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApprovePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'petugas_id' => ['required', 'exists:petugas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'petugas_id.required' => 'Pilih petugas yang akan ditugaskan.',
        ];
    }
}