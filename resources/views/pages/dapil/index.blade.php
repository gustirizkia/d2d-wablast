@extends('layouts.admin')


@section('title')
    Daerah Pilih
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{route("admin.real-count.dapil.create")}}" class="btn btn-warning mb-4">Tambah Data</a>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Nama DAPIL</th>
                    <th scope="col">Jumlah Caleg</th>
                    <th scope="col">Jumlah Saksi</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">{{$item->title}}</th>
                            <td>{{$item->caleg_count}}</td>
                            <td>{{$item->saksi_count}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route('admin.real-count.dapil.edit', $item->uuid)}}" class="btn btn-info">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
