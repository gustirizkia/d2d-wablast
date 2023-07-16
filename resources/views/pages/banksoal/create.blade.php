@extends('layouts.admin')

@section('title')
    Tambah Data Bank Soal
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{route('admin.bank-soal.store')}}" method="post">
            @csrf
                <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="">
                        <label class="form-label">Soal</label>
                        <textarea class="form-control" required name="soal" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;"></textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="">
                        <label class="form-label">Deskripsi <i>(optional)</i></label>
                        <textarea class="form-control" name="deskripsi" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;"></textarea>
                    </div>
                </div>
                </div>
                <div class="my-4">
                <hr>
                </div>
                <div class="pilihan">
                    <div class="mb-3">
                        <label for="" class="form-label">Pilihan 1</label>
                        <input type="text" placeholder="" name="pilihan[0]" required class="form-control">
                    </div>
                </div>
                <div class="text-center mt-3">
                    <div class="btn btn-outline-warning add_pilihan">Tambah Pilihan</div>
                </div>

                <div class="mt-5">
                    <button class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('addScript')
    <script>
        let i = 0;
        $(".add_pilihan").on("click", function(){
           i++;

           $(".pilihan").append(`
                <div class="mb-3">
                    <label for="" class="form-label">Pilihan ${i+1}</label>
                    <input type="text" placeholder="" required name="pilihan[${i}]" class="form-control">
               </div>
            `)
        });
    </script>
@endpush
