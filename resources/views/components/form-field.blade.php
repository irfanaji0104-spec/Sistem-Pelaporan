@props([
    'name',
    'label'       => null,
    'type'        => 'text',
    'value'       => null,
    'placeholder' => '',
    'required'    => false,
    'readonly'    => false,
    'help'        => null,
    'options'     => null,   // untuk select: ['value' => 'Label']
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1">
            {{ $label }}
            @if ($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    @if ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}"
                {{ $required ? 'required' : '' }}
                {{ $readonly ? 'disabled' : '' }}
                class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
            @foreach ($options ?? [] as $optValue => $optLabel)
                <option value="{{ $optValue }}" @selected(old($name, $value) == $optValue)>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}"
                  placeholder="{{ $placeholder }}"
                  rows="4"
                  {{ $required ? 'required' : '' }}
                  class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition resize-y">{{ old($name, $value) }}</textarea>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}"
               {{ $required ? 'required' : '' }}
               {{ $readonly ? 'readonly' : '' }}
               class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 {{ $readonly ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : 'bg-slate-50 focus:bg-white' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
    @endif

    @if ($help)
        <p class="text-xs text-slate-400 mt-1">{{ $help }}</p>
    @endif

    @error($name)
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>