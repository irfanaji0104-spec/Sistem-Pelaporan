@php
    $user = auth()->user();
@endphp

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-slate-800 transition">
        {{-- Avatar inisial --}}
        @if ($user->foto_profil)
            <img src="{{ asset('storage/'.$user->foto_profil) }}"
                 alt="{{ $user->name }}"
                 class="w-8 h-8 rounded-full object-cover border border-slate-700">
        @else
            <div class="w-8 h-8 rounded-full bg-blue-700 text-white text-xs font-bold flex items-center justify-center border border-slate-700">
                {{ $user->inisial }}
            </div>
        @endif

        <span class="hidden sm:inline text-sm text-slate-200">
            {{ $user->name }} ({{ ucfirst($user->role) }})
        </span>

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Dropdown --}}
    <div x-show="open" @click.outside="open = false" x-cloak
         class="absolute right-0 mt-2 w-56 bg-white rounded-lg border border-slate-200 shadow-lg py-1.5 z-20">
        <div class="px-4 py-2 border-b border-slate-100">
            <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->name }}</p>
            <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
        </div>

        @php
            $settingRoute = $user->isAdmin() ? 'admin.pengaturan' : 'pelapor.pengaturan';
        @endphp

        <a href="{{ route($settingRoute) }}"
           class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Pengaturan Akun
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>