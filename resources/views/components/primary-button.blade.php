<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#434a11] border border-transparent rounded-md font-semibold text-xs text-[#d4d9a1] uppercase tracking-widest hover:bg-[#5b6135] focus:bg-[#5b6135] active:bg-[#434a11] focus:outline-none focus:ring-2 focus:ring-[#d4d9a1] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
