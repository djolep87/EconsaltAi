<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-blue-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-green-700 hover:to-blue-700 focus:from-green-700 focus:to-blue-700 active:from-green-800 active:to-blue-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl']) }}>
    {{ $slot }}
</button>
