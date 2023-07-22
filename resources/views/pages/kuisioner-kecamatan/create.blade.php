@extends('layouts.admin')

@section('title')
    Tambah data kuisioner kecamatan
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{route('admin.data.kuisioner-kecamatan.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Provinsi</label>
                        <select required name="provinsi" id="provinsi" class="form-select">
                            <option >Pilih Kota</option>
                            @foreach ($provinsi as $item)
                                <option value="{{$item->id_provinsi}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kota/Kabupaten</label>
                        <select required name="kota" id="kota" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="" class="form-label">Kecamatan</label>
                        <select required name="kecamatan" id="kecamatan" class="form-select">
                        </select>
                    </div>
                </div>

                <label for="" class="form-label">Pilih Soal</label>
                @foreach ($soal as $item)
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
