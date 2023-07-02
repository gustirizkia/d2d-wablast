@extends('layouts.admin')

@section('title')
    Bank Soal
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-between mb-3">
                <div class="col-6">
                    <a href="{{route('admin.bank-soal.create')}}" class="btn btn-primary">Tambah Data</a>
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
            <table class="table">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Soal</th>
                <th scope="col">Dibuat</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['soal'] as $key => $item)
                    <tr>
                        <th scope="row">{{ $data['soal']->firstItem() + $key }}</th>
                        <td>{{$item->title}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{route('admin.bank-soal.show', $item->id)}}" class="btn btn-success btn-sm">
                                    <i class="bi bi-eye"></i>
                                    <span class="ms-1">Detail</span>
                                </a>
                                <a href="{{route('admin.bank-soal.edit', $item->id)}}" class="btn btn-primary btn-sm ms-2">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="ms-1">Edit</span>
                                </a>
                                <form action="{{ route('admin.bank-soal.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method("DELETE")
                                    <span class="btn btn-danger btn-sm px-2 py-1 text-sm ms-2 delete_confirm cursor-pointer">
                                        <i class="bi bi-trash"></i><span class="ms-1">Delete</span>
                                    </span>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12">
                            <div class="text-center fw-bold">Tidak Ada Data</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
@endsection

@push('addScript')
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
