@extends('layouts.admin')

@section('title')
    Whatsapp Blast
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-3">
                    <a href="{{ route("admin.wa.create") }}" class="btn btn-primary">Tambah Data</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Pesan yang akan dikirim</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($message as $item)
                        <tr>
                            <td>
                                {{ $item->message }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="" class="btn btn-primary">Edit</a>
                                    <form action="">
                                        <span class="btn btn-danger delete_confirm ms-2">Hapus</span>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
