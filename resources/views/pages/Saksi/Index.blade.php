@extends('layouts.admin')

@section('title')
    Saksi
@endsection

@section('content')
    <div class="card" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('admin.real-count.saksi.create')}}" class="btn btn-warning">Tambah Data</a>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Dapil</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <th scope="row">{{$item->name}}</th>
                            <td>{{$item->email}}</td>
                            <td>{{$item->saksi->dapil->title}}</td>
                            <td>
                                <a href="" class="btn btn-info">Edit</a>
                                <form action="{{ route('admin.real-count.saksi.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method("DELETE")
                                    <span class="btn btn-danger   ms-2 delete_confirm cursor-pointer">
                                        <span class="ms-1">Delete</span>
                                    </span>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
