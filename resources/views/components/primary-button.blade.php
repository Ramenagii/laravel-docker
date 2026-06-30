<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-150 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none']) }} wire:loading.attr="disabled">
    {{ $slot }}
</button>
