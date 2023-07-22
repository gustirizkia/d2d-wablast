@extends('layouts.admin')

@section('title')
    Detail Responden {{$item->nama}}
@endsection

@section('content')
<a href="{{route('admin.responden-exportDetail', $item->id)}}" class="btn btn-success mb-4"><i class="bi bi-file-earmark-spreadsheet-fill"></i><span class="ms-2">Export</span></a>
<div class="card mb-4">
    <div class="card-header">
        Profile Responden
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label for="" class="form-label">Nama</label>
                <p>{{$item->nama}}</p>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Provinsi</label>
                <p>{{$item->rel_provinsi->nama}}</p>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Kota/Kabupaten</label>
                <p>{{$item->rel_kota->nama}}</p>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Kecamatan</label>
                <p>{{$item->rel_kecamatan->nama}}</p>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Desa</label>
                <p>{{$item->rel_desa->nama}}</p>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Alamat</label>
                <p>{{$item->alamat}}</p>
            </div>
            <div class="col-md-2">
                <label for="" class="form-label">Foto Bersama Surveyor</label>
                @if ($item->foto_bersama)
                    <img src="{{url("storage/$item->foto_bersama")}}" alt="" class="img-fluid">
                @else
                    <p class="fw-bold">Tidak ada</p>
                @endif
            </div>
        </div>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            Hasil Survey
        </div>
        <div class="card-body">

            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Pertanyaan</th>
                        <th scope="col">Jawaban</th>
                        <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $dataItem)
                            <tr>
                                <td>{{$dataItem->soal->title}}</td>
                                <td>{{$dataItem->yes_no ? $dataItem->yes_no : $dataItem->pilihan->title }}</td>
                                <td>{{$dataItem->created_at }}</td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
