@extends('layouts.admin')

@section('title')
    Tambah Calon Legislatif
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <div class="h4">Isi Data Diri Calon</div>
        </div>
        <form action="{{route('admin.calon-legislatif.update', $item->id)}}" method="post">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{$item->nama}}" required name="nama">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Dapil</label>
                    <input type="text" class="form-control" required name="dapil" value="{{$item->dapil}}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Provinsi</label>
                    <select required name="provinsi" id="provinsi" class="form-control">
                        @foreach ($provinsi as $prov)
                            <option value="{{$prov->province_id}}" {{$prov->province_id === $item->provinsi_id ? 'selected' : ''}}>{{$prov->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Kota/Kabupaten</label>
                    <select required name="kota" id="kota" class="form-control">
                        @foreach ($kota as $city)
                            <option value="{{$city->city_id}}" {{$city->city_id === $item->kota_id ? 'selected' : ''}}>{{$city->city_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Kecamatan</label>
                    <select required name="kecamatan" id="kecamatan" class="form-control">
                        @foreach ($kecamatan as $kec)
                            <option value="{{$kec->subdistrict_id}}" {{$kec->subdistrict_id === $item->kecamatan_id ? 'selected' : ''}}>{{$kec->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('addScript')
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
                        tagHtml += `<option value="${element.city_id}">${element.city_name}</option>`
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
                        tagHtml += `<option value="${element.subdistrict_id}">${element.name}</option>`
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
