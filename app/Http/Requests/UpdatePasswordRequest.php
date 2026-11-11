<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    /**
     * Validasi tambahan: password lama harus benar.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            if (!Hash::check($this->input('password_lama'), auth()->user()->password)) {
                $v->errors()->add('password_lama', 'Password lama tidak sesuai.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min'      => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'=> 'Konfirmasi password baru tidak cocok.',
        ];
    }
}