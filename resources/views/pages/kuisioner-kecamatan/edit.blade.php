@extends('layouts.admin')

@section('title')
    Edit Data
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{route('admin.data.bank-soal.update', $item->id)}}" method="post">
            @csrf
            @method("PUT")
                <input type="text" class="input_tipe_pilihan" value="{{$item->yes_no ? "ya_tidak" : 'mulitple'}}" name="tipe_pilihan" hidden>
                <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="">
                        <label class="form-label">Soal</label>
                        <textarea class="form-control" required name="soal" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;">{{$item->title}}</textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="">
                        <label class="form-label">Deskripsi/Notes  <i>(optional)</i></label>
                        <textarea class="form-control" name="deskripsi" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;">{{$item->subtitle}}</textarea>
                    </div>
                </div>
                </div>

                <div class="">
                    <label class="form-label">Pilihan</label>
                </div>

                {{-- select type pilihan --}}
                <div class="card" id="pilihan_ganda">
                  <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a href="#tabs-home-1" class="nav-link {{$item->yes_no === 0 ? "active" : ""}}" tipe-pilihan="mulitple" data-bs-toggle="tab" aria-selected="{{$item->yes_no === 0 ? "true" : "false"}}" role="tab">Multiple Choice</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="#tabs-profile-1" class="nav-link {{$item->yes_no === 1 ? "active" : ""}}" tipe-pilihan="ya_tidak" data-bs-toggle="tab" aria-selected="{{$item->yes_no === 1 ? "true" : "false"}}" role="tab" tabindex="-1">Hanya Ya atau Tidak</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane {{$item->yes_no === 0 ? "active show" : ''}}" id="tabs-home-1" role="tabpanel">
                        {{-- data pilihan ganda --}}
                            @if (count($item->pilihan))
                                <div class="pilihan">
                                    @foreach ($item->pilihan as $key => $pilihan)
                                        <div class="mb-3" id="pilihan_id_{{$key}}">
                                            <label for="" class="form-label">Pilihan {{$key+1}} <span class="text-danger remove_pilihan" data-id="{{$key}}"><i class="bi bi-x-circle-fill"></i></span></label>
                                            <input type="text" placeholder="" name="pilihan[{{$key}}][title]" value="{{$pilihan->title}}"  class="form-control">
                                            <input type="number" value="{{$pilihan->id}}" name="pilihan[{{$key}}][id]" hidden>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="pilihan">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Pilihan 1</label>
                                        <input type="text" placeholder="" name="pilihan[0]" class="form-control">
                                    </div>
                                </div>

                            @endif


                        <div class="text-center mt-3">
                            <div class="btn btn-outline-warning add_pilihan">Tambah Pilihan</div>
                        </div>
                        {{-- end data pilihan ganda --}}
                      </div>
                      <div class="tab-pane {{$item->yes_no === 1 ? "active show" : ''}}" id="tabs-profile-1" role="tabpanel">
                        <h4>Hanya Iya atau Tidak</h4>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- select type pilihan end --}}

                <div class="mt-5">
                    <button class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('addScript')
    <script>
        @if(count($item->pilihan))
            let i = {{ count($item->pilihan) ? count($item->pilihan) : 0}};
            $(".add_pilihan").on("click", function(){
            i++;

            $(".pilihan").append(`
                    <div class="mb-3" id="pilihan_id_${i}">
                        <label for="" class="form-label">Pilihan ${i} <span class="text-danger remove_pilihan" data-id="{{$key}}"><i class="bi bi-x-circle-fill"></i></span></label>
                        <input type="text" placeholder="" required name="new_pilihan[${i}]" class="form-control">
                </div>
                `)
            });
        @else
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
        @endif


        $(".remove_pilihan").on("click", function(){
            let data_id = $(this).attr("data-id")

            $(`div`).remove(`#pilihan_id_${data_id}`);
        });

        $("#pilihan_ganda .nav-link").on("click", function(){
            let tipe = $(this).attr("tipe-pilihan")

            $(".input_tipe_pilihan").val(tipe);
        })
    </script>
@endpush
