@extends('layouts.admin')

@section('title')
    Responden
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{route('admin.responden-export')}}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet-fill"></i><span class="ms-2">Export</span></a>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->alamat}}</td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
