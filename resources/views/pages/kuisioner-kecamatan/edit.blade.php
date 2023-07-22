@extends('layouts.admin')

@section('title')
    Edit data kuisioner kecamatan {{$item_kecamatan->nama}}
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{route('admin.data.kuisioner-kecamatan.update', $item_kecamatan->id_kecamatan)}}" method="post">
                @csrf
                @method("PUT")
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Provinsi</label>
                        <input type="text" class="form-control" readonly disabled value="{{$item_provinsi->nama}}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kota/Kabupaten</label>
                        <input type="text" class="form-control" readonly disabled value="{{$item_kota->nama}}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" readonly disabled value="{{$item_kecamatan->nama}}">
                    </div>
                </div>

                <label for="" class="form-label">Pilih Soal</label>
                @foreach ($soal_has_kecamatan as $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="soal_id_active[]" value="{{$item->soal->id}}" id="flexCheckDefault{{$item->soal->id}}" checked>
                        <label class="form-check-label" for="flexCheckDefault{{$item->soal->id}}">
                            {{$item->soal->title}}
                        </label>
                    </div>
                @endforeach
                @foreach ($soalNotSelect as $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="soal_id[]" value="{{$item->id}}" id="flexCheckDefault{{$item->id}}">
                        <label class="form-check-label" for="flexCheckDefault{{$item->id}}">
                            {{$item->title}}
                        </label>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-warning mt-3">Simpan</button>
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

        $("#pilihan_ganda .nav-link").on("click", function(){
            let tipe = $(this).attr("tipe-pilihan")

            $(".input_tipe_pilihan").val(tipe);
        })
    </script>

    <script>
        $("#provinsi").on("change", function(){
            let value = $(this).val();

            $.ajax({
                url: `{{route('listKota')}}?provinsi=${value}`,
                type: "GET",
                success: function(data){
                    console.log('data', data.data)
                    let tagHtml = "<option >Pilih kota</option>";

                    let tempData = data.data;
                    tempData.forEach(element => {
                        tagHtml += `<option value="${element.id_kota}">${element.nama}</option>`
                    });

                    $("#kota").html(tagHtml);


                },
                error: function(err){
                    console.log('err', err)
                }
            })
        })
        $("#kota").on("change", function(){
            let value = $(this).val();

            $.ajax({
                url: `{{route('listKecamatan')}}?kota=${value}`,
                type: "GET",
                success: function(data){
                    console.log('data', data.data)
                    let tagHtml = "<option >Pilih kecamatan</option>";

                    let tempData = data.data;
                    tempData.forEach(element => {
                        tagHtml += `<option value="${element.id_kecamatan}">${element.nama}</option>`
                    });

                    $("#kecamatan").html(tagHtml);


                },
                error: function(err){
                    console.log('err', err)
                }
            })
        })
    </script>
@endpush
