<?php

namespace App\Http\Requests\Pelapor;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPelapor();
    }

    public function rules(): array
    {
        return [
            'lokasi_id'   => ['required', 'exists:lokasi,id'],
            'kategori_id' => ['required', 'exists:kategori_kerusakan,id'],
            'deskripsi'   => ['required', 'string', 'min:10', 'max:1000'],
            'foto_bukti'  => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'lokasi_id.required'    => 'Pilih lokasi / ruangan terlebih dahulu.',
            'lokasi_id.exists'      => 'Lokasi tidak valid.',
            'kategori_id.required'  => 'Pilih kategori kerusakan terlebih dahulu.',
            'kategori_id.exists'    => 'Kategori tidak valid.',
            'deskripsi.required'    => 'Deskripsi kerusakan wajib diisi.',
            'deskripsi.min'         => 'Deskripsi minimal 10 karakter.',
            'deskripsi.max'         => 'Deskripsi maksimal 1000 karakter.',
            'foto_bukti.required'   => 'Foto bukti wajib diunggah.',
            'foto_bukti.image'      => 'File harus berupa gambar.',
            'foto_bukti.mimes'      => 'Format foto harus JPG atau PNG.',
            'foto_bukti.max'        => 'Ukuran foto maksimal 2MB.',
        ];
    }
}