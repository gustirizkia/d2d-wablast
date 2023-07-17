@extends('layouts.admin')

@section('title')
    Bank Soal
@endsection

@section('content')
{{-- {{dd($filter)}}; --}}
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-between mb-3">
                <div class="col-6">
                    <a href="{{route('admin.bank-soal.create')}}" class="btn btn-warning">Tambah Data</a>
                    <a href="{{route('admin.exportDataSoal')}}" class="btn btn-success ms-2">Ekspor Excel</a>
                    @if ($filter)
                        <a href="/admin/bank-soal" class="btn btn-secondary ms-2 filter_btn">Reset</a>
                    @else
                        <button class="btn btn-secondary ms-2 filter_btn">Filter</button>
                    @endif
                </div>
                <div class="col-md-3 col-6">
                    <div class="input-icon">
                        <input type="text" value="" class="form-control" placeholder="Search…" name="q">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Responden</th>
                        <form action="" id="form_filter" method="GET">
                        @forelse ($data['soal'] as $key => $item)

                            <th scope="col">
                                <div class="">
                                    {{$item->title}}
                                </div>

                                    <select name="filter[]" id="key_soal_{{$key}}" class="form-select form-select-sm filter_pilihan">
                                        <option value="">All</option>
                                        @foreach ($item->pilihan as $pg)
                                            @if ($filter)

                                                <option value="{{$pg->id}}" {{(int)$filter[$key] === $pg->id ? 'selected' : '' }}>{{$pg->title}} ada filter</option>
                                            @else
                                                <option value="{{$pg->id}}" >{{$pg->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    {{-- <input type="checkbox" name="OK[{{$key+1}}]" value="ok 1" checked>
                                    <input type="checkbox" name="OK[{{$key+1}}]" value="ok 2" checked> --}}
                                </th>
                            @empty
                            </form>

                        @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['responden'] as $index => $item)
                            <tr id="{{$index}}">
                                <th scope="row">
                                    <span style="font-size: 10px">{{ $item->nama }}</span>
                                </th>
                                @for ($i = 0; $i < count($data['soal']); $i++)
                                    <td>
                                        <span style="font-size: 10px">{{ $item->pilihanTarget->where("soal_id", $data['soal'][$i]->id)->first()->pilihan->title }}</span>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{-- {{$data['soal']->links()}} --}}
            </div>
        </div>
    </div>
@endsection

@push('addScript')

<script>
    $(".filter_btn").click(function(){
        $("#form_filter").submit();
    });

    $(".filter_pilihan").on("change", function(){
        let key_id = $(this).attr("id");
        let value = $(this).val();

        console.log('value', value)
        console.log('key_id', key_id)
    })


</script>
@if ($filter)
    @foreach ($data['responden'] as $index => $item)
        @php
            $removeClass = true;
        @endphp
            @for ($i = 0; $i < count($data['soal']); $i++)
                @if ($item->pilihanTarget->where("soal_id", $data['soal'][$i]->id)->first()->pilihan->id === (int)$filter[$i])
                    @php
                        $removeClass = false;
                    @endphp

                @endif
            @endfor
        @if ($removeClass)
            <script>
                $("tr").remove("#{{$index}}");
            </script>
        @endif
    @endforeach
@endif

    <script>
        $('.delete_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: `Hapus data`,
                // text: "If you delete this, it will be gone forever.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
