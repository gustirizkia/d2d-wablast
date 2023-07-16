@extends('layouts.admin')

@section('title')
    Edit User {{$item->name}}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.user.update', $item->id)}}" method="POST">
                @csrf
                @method("PUT")
                <div class="mb-3">
                    <label for="" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" required value="{{$item->name}}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email')is-invalid @enderror" name="email" required value="{{$item->email}}">
                    @error('email')
                        <small class="text-danger">
                            <i>{{$message}}</i>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nomor Telepon</label>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" required value="{{$item->phone}}">
                    @error('phone')
                        <small class="text-danger">
                            <i>{{$message}}</i>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  >
                    <small>Kosongkan jika tidak ingin diubah</small>
                </div>

                <button type="submit" class="btn btn-warning">Simpan Data</button>
            </form>
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
