@extends('layouts.admin')

@section('title')
    Surveyor
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-between mb-3">
                <div class="col-6">
                    <a href="{{route('admin.data.user.create')}}" class="btn btn-warning">Tambah Data</a>
                </div>
                <div class="col-md-3 col-6">
                    <form action="">
                        <div class="input-icon">
                            <input type="text"  class="form-control" placeholder="Search…" value="{{request()->get("q")}}" name="q">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['user'] as $key => $item)
                            <tr>
                                <td>{{ $data['user']->firstItem() + $key }}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.data.user.edit', $item->id)}}" class="btn btn-warning ">
                                            <i class="bi bi-pen"></i>
                                            <span class="ms-1">Edit</span>
                                        </a>
                                        <a href="{{route('admin.data.user.show', $item->id)}}" class="btn btn-info  ms-2">
                                            <i class="bi bi-eye"></i>
                                            <span class="ms-1">Detail</span>
                                        </a>
                                        <form action="{{ route('admin.data.bank-soal.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <span class="btn btn-danger   ms-2 delete_confirm cursor-pointer">
                                                <i class="bi bi-trash"></i><span class="ms-1">Delete</span>
                                            </span>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">
                                    <div class="text-center fw-bold">No Data</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{$data['user']->links("pagination::bootstrap-5")}}
            </div>
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
