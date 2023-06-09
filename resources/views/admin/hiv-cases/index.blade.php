<x-app-layout>
    <x-breadcrumbs name="hiv-cases" />
    <h1 class="font-semibold text-lg my-8">Daftar Kasus HIV</h1>

    <x-card-container>
        <div class="sm:flex justify-between items-end">
            <div class="lg:flex gap-x-2">
                {{-- Filter provinsi --}}
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="text-xs font-medium">Filter Provinsi</span>
                    </label>
                    <select class="select select-bordered" name="provinceFilter" id="provinceFilter">
                        <option disabled selected>Pilih provinsi</option>
                        @forelse ($provinces as $province)
                            <option value="{{$province->id}}">{{$province->name}}</option>
                        @empty
                            <option disabled selected>Tidak ada provinsi</option>
                        @endforelse
                    </select>
                </div>

                {{-- Filter tahun --}}
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="text-xs font-medium">Filter Tahun</span>
                    </label>
                    <select class="select select-bordered" name="yearFilter" id="yearFilter">
                        <option disabled selected>Pilih Tahun</option>
                        @forelse ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @empty
                            <option disabled selected>Tidak ada provinsi</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="block md:flex gap-x-2">
                <x-link-button route="{{ route('admin.hiv-case.create') }}" color="gray">
                    Tambah Kasus
                </x-link-button>
                <x-link-button id="btnImport" class="bg-primary">
                    Import Kasus
                </x-link-button>
                <form action="{{ route('admin.hiv-case.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_file" hidden>
                    <input type="submit" hidden>
                </form>
            </div>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table id="hivTable" class="w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>IDKD</th>
                        <th>Lokasi</th> <!-- Provinsi, Bagian, Kota/Kabupaten, Kecamatan -->
                        <th>Umur</th>
                        <th>Gender</th>
                        <th>Transmisi</th>
                        <th>Tahun</th>
                        <th>Menu</th>
                    </tr>
                </thead>
            </table>
        </div>
    </x-card-container>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="modal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">
                Konfirmasi Penghapusan
            </h3>
            <p class="py-4">
                Apakah kamu yakin ingin menghapus data <span id="data" class="font-semibold"></span> ini?
            </p>
            <div class="modal-action">
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 px-2 rounded-md text-sm p-2 text-center inline-flex items-center">
                        Hapus
                    </button>
                </form>
                <label for="modal"
                    class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 px-2 rounded-md text-sm p-2 text-center inline-flex items-center">
                    Batal
                </label>
            </div>
        </div>
    </div>

    @push('js-internal')
        <script>
            function btnDelete(dataId, dataName) {
                let id = dataId;
                let name = dataName;
                // console.log(id, name);
                let url = '{{ route('admin.hiv-case.destroy', ':id') }}';
                let urlDelete = url.replace(':id', id);

                $('#data').html(name);
                $('form').attr('action', urlDelete);
            }

            $('#btnImport').on('click', function() {
                $('input[name="import_file"]').click();

                $('input[name="import_file"]').on('change', function() {
                    $('input[type="submit"]').click();
                });
            });

            $(function() {
                // add loading when submit form
                $('form').on('submit', function() {
                    Swal.fire({
                        title: 'Mohon tunggu',
                        text: 'Sedang memproses data',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                });

                $('#filter').on('change', function() {
                    let value = $(this).val();

                    // filter datatable by province
                    $('#hivTable').DataTable().column(2).search(value).draw();
                });


                $('#hivTable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('admin.cases.hiv') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'idkd',
                            name: 'idkd'
                        },
                        {
                            data: 'location',
                            name: 'location'
                        },
                        {
                            data: 'age',
                            name: 'age'
                        },
                        {
                            data: 'sex',
                            name: 'sex'
                        },
                        {
                            data: 'transmission',
                            name: 'transmission'
                        },
                        {
                            data: 'year',
                            name: 'year'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('#provinceFilter').on('change', function() {
                    let value = $(this).val();
                    let url = "{{ route('admin.cases.hiv') }}";
                    url = url + '?province=' + value;

                    $('#hivTable').DataTable().ajax.url(url).load();
                })

                $('#yearFilter').on('change', function() {
                    let value = $(this).val();
                    let url = "{{ route('admin.cases.hiv') }}";
                    url = url + '?year=' + value;

                    $('#hivTable').DataTable().ajax.url(url).load();
                })
            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                });
            @endif
        </script>
    @endpush
</x-app-layout>
