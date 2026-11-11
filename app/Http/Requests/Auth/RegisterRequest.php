<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'role'     => ['required', Rule::in(['siswa', 'guru'])], // hardcode, tolak admin
            'no_induk' => ['required', 'string', 'max:50', 'unique:users,no_induk'],
            'email'    => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'role.required'      => 'Pilih daftar sebagai Siswa atau Guru.',
            'role.in'            => 'Role tidak valid. Hanya Siswa atau Guru yang boleh daftar.',
            'no_induk.required'  => 'NIS / NIP wajib diisi.',
            'no_induk.unique'    => 'NIS / NIP sudah terdaftar.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}