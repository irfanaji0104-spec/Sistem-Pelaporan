<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PetugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama'          => ['required', 'string', 'max:100'],
            'kontak'        => ['required', 'string', 'max:30'],
            'spesialisasi'  => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'         => 'Nama petugas wajib diisi.',
            'kontak.required'       => 'Kontak wajib diisi.',
            'spesialisasi.required' => 'Spesialisasi wajib diisi.',
        ];
    }
}