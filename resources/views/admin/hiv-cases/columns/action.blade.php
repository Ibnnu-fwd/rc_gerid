<div class="lg:flex gap-x-2">
    <a href="{{ route('admin.hiv-case.show', $case->id) }}"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
        <i class="fas fa-eye fa-sm"></i>
    </a>
    <a href="{{ route('admin.hiv-case.edit', $case->id) }}"
        class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
        <i class="fas fa-edit fa-sm"></i>
    </a>
    <label for="modal" onclick="btnDelete('{{ $case->id }}', '{{ $case->idkd }}')"
        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
        <i class="fas fa-trash fa-sm"></i>
    </label>
</div>
