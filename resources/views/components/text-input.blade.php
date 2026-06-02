@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#434a11] focus:ring-[#434a11] rounded-md shadow-sm']) }}>
