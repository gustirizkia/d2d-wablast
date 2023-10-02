@extends('layouts.admin')

@section('title')
    Whatsapp Blast
@endsection

@push('addStyle')
    <style>
        img{
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
    </style>
@endpush

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
                    <th scope="col">Image</th>
                    <th scope="col">Pesan yang akan dikirim</th>
                    <th scope="col">Jumlah Jawaban</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($message as $item)
                        <tr>
                            <td>
                                @if ($item->image)
                                    <img src="{{ asset("storage/$item->image") }}" class="img" alt="">
                                @else
                                    Tidak ada image
                                @endif
                            </td>
                            <td>
                                <div  style="cursor: pointer" class="text-primary">{{ $item->message }}</div>
                            </td>
                            <td>
                                {{ $item->msg_has_jawaban_count }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    {{-- <a href="{{ route("admin.wa.edit", $item->id) }}" class="btn btn-primary">Edit</a> --}}
                                    <form action="{{ route("admin.wa.destroy", $item->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <span class="btn btn-danger delete_confirm ms-2">Hapus</span>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $message->links("pagination::bootstrap-5") }}
            </div>
        </div>
    </div>
@endsection
