@extends('layouts.admin')

@section('title')
    Edit Data Bank Soal {{$item->title}}
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{route('admin.data.bank-soal.update', $item->id)}}" method="post">
            @csrf
            @method("PUT")
                <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="">
                        <label class="form-label">Soal</label>
                        <textarea class="form-control" required name="soal" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;">{{$item->title}}</textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="">
                        <label class="form-label">Deskripsi <i>(optional)</i></label>
                        <textarea class="form-control" name="deskripsi" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;">{{$item->subtitle}}</textarea>
                    </div>
                </div>
                </div>
                <div class="my-4">
                <hr>
                </div>
                <div class="pilihan">
                    @foreach ($item->pilihan as $key => $pilihan)
                        <div class="mb-3" id="pilihan_id_{{$key}}">
                            <label for="" class="form-label">Pilihan {{$key+1}} <span class="text-danger remove_pilihan" data-id="{{$key}}"><i class="bi bi-x-circle-fill"></i></span></label>
                            <input type="text" placeholder="" name="pilihan[{{$key}}][title]" value="{{$pilihan->title}}" required class="form-control">
                            <input type="number" value="{{$pilihan->id}}" name="pilihan[{{$key}}][id]" hidden>
                        </div>
                    @endforeach
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


        let i = {{count($item->pilihan)}};
        $(".add_pilihan").on("click", function(){
           i++;

           $(".pilihan").append(`
                <div class="mb-3" id="pilihan_id_${i}">
                    <label for="" class="form-label">Pilihan ${i} <span class="text-danger remove_pilihan" data-id="{{$key}}"><i class="bi bi-x-circle-fill"></i></span></label>
                    <input type="text" placeholder="" required name="new_pilihan[${i}]" class="form-control">
               </div>
            `)
        });

        $(".remove_pilihan").on("click", function(){
            let data_id = $(this).attr("data-id")

            $(`div`).remove(`#pilihan_id_${data_id}`);
        });
    </script>
@endpush
