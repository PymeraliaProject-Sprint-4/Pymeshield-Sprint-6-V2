<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-white text-red-800 font-weight:700 border border-transparent rounded-md font-bold text-xs uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:bg-gray-300 dar:hover:bg-gray-200 dark:active:bg-gray-300 dark:focus:bg-gray-300  focus:outline-none  focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
