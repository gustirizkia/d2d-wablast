@extends('layouts.admin')

@section('title')
    Detail Surveyor {{$item->name}}
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-status-top bg-warning">

            </div>
            <div class="card-body">
                <div class="h3 mb-0">
                    Jumlah Responden
                </div>
                <div class="">
                    {{$count['responden']}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-status-top bg-warning">

            </div>
            <div class="card-body">
                <div class="h3 mb-0">
                    Jumlah Kecamatan
                </div>
                <div class="">
                    {{$count['responden_kecamatan']}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-status-top bg-success">

            </div>
            <div class="card-body">
                <div class="h3 mb-0">
                    Jumlah Kota
                </div>
                <div class="">
                    {{$count['responden_kota']}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-status-top bg-primary">

            </div>
            <div class="card-body">
                <div class="h3 mb-0">
                    Jumlah Provinsi
                </div>
                <div class="">
                    {{$count['responden_kota']}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="fw-bold">Lokasi Tugas di Kota/Kabupaten</div>
        @foreach ($targetkota as $index => $item)
            {{$item->kota->nama}}{{$index !== count($targetkota)-1 ? "," : ""}} {{" "}}
        @endforeach
    </div>
</div>

    <div class="card">
        <div class="card-body">
            <a href="{{route('admin.responden-export')}}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet-fill"></i><span class="ms-2">Export</span></a>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Provinsi</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Desa</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($responden as $dataItem)
                            <tr>
                                <td>{{$dataItem->nama}}</td>
                                <td>{{$dataItem->alamat}}</td>
                                <td>{{$dataItem->rel_provinsi->nama}}</td>
                                <td>{{$dataItem->rel_kota->nama}}</td>
                                <td>{{$dataItem->rel_kecamatan->nama}}</td>
                                <td>{{$dataItem->rel_desa->nama}}</td>
                                <td>{{$dataItem->created_at}}</td>
                                <td>
                                    <a href="{{route('admin.data.responden.show', $dataItem->id)}}" class="btn btn-info">Detail</a>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{$responden->links("pagination::bootstrap-5")}}
            </div>
        </div>
    </div>

@endsection
