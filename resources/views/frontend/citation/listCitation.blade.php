@extends('frontend.layout')
<style>
    table.dataTable td {
        word-break: break-word;
    }
</style>
@section('content')
    <section class="px-5 py-2 align-top "> 
        <p id="tableInfo" class="pt-2"></p>
        <div class="dt-responsive table-responsive">
            <table class="table nowrap" style="border:none" id="samplesTable">
                <thead style="display: none">
                    <tr>
                        <th style="width: 1em">Column 1</th>
                        <th style="width: 90%; background-color: red">Column 2</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listCitations as $item)
                    <tr>
                        <td style="width: 1;border:none" class="align-top">
                            <input class="form-check-input" type="checkbox" id="check1" name="option1" value="something">
                            <p class="text-center">{{ $loop->iteration }}</p>
                        </td>
                        <td style="width: 10px;  ">
                            <div class="text-start">
                                <div class="mb-1 text-xs text-gray-400">{{ $item['user'] }}</div>
                                <div class="container-title" >
                                    <a href="{{ route('detailCitation', $item['id_citation']) }}" class="text-blue-500" style="word-break: break-word;white-space:normal;">{{ $item['title'] }}</a>
                                </div>
                                <h6 class="pb-0">{{ $item['province'].",".$item['regency'] }}</h6>
                                <p>{{ $item['author']->name.",".$item['author']->member }} | {{ $item['monthYear'] }}</p>
                                <span class="text-gray-400">Accession NCBI : {{ $item['accession_ncbi'] }}</span><span class="text-gray-400"> | Accession INDAGI : {{ $item['accession_indagi'] }}</span>
                                <h6><a href="{{ route('detailFasta', $item['id_citation']) }}" class="text-blue-500">Fasta</a> </h6>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
@push('js-internal')
    <script>
         $(function () {
            var table = $('#samplesTable').DataTable({
                responsive: true,
                dom:'rtp'
            });
            var info = table.page.info();
            console.log(info);
            $('#tableInfo').html(
                'Items : '+(info.page+1)+' to '+info.length+' of ' +info.pages 
            );
        });
    </script>
@endpush