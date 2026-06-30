<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2.5 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-150 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none']) }} wire:loading.attr="disabled">
    {{ $slot }}
</button>
