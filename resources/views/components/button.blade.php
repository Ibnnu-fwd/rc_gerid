@props(['color' => 'green', 'type' => 'submit', 'class' => ''])

<button
    {{ $attributes->merge([
        'type' => $type == 'submit' ? 'submit' : 'button',
        'class' =>
            $class .
            ' inline-flex items-center px-4 py-2 btn-primary border border-transparent rounded-md text-xs lg:text-xs text-white bg-' .
            $color .
            '-600 hover:bg-' .
            $color .
            '-500 focus:outline-none focus:ring-2 focus:ring-' .
            $color .
            '-500 focus:ring-offset-2 transition ease-in-out duration-150 ',
    ]) }}>
    {{ $slot }}
</button>
