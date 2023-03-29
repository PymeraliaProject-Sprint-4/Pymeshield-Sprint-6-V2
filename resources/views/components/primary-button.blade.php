<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded items-center']) }}>
    {{ $slot }}
</button>
