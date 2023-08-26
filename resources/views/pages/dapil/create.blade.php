@extends('layouts.admin')

@section('title')
    Tambah DAPIL
@endsection

@push('addStyle')
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush

@section('content')
<div class="" x-data="funcData">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="form-label">Gambar/Thumbnail</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nama DAPIL</label>
                <input type="text" class="form-control" name="nama">
            </div>

            <hr>




        </div>
    </div>
    <template x-for="calon in calons">
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Calon</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="" class="form-label">Nomor Calon</label>
                            <input type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <div class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div class="">
        <button class="btn-warning btn w-100 d-block">Tambah Data</button>
    </div>

    <button type="submit" class="btn btn-warning">Simpan</button>
</div>
@endsection


@push('addScript')
    <script>
        function funcData(){
            return{
                calons: [
                    {
                        nomor: 01,
                        nama: null
                    },
                    {
                        nomor: 02,
                        nama: null
                    },
                ]
            }
        }
    </script>
@endpush

