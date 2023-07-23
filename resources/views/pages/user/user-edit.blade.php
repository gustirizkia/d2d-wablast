@extends('layouts.admin')

@section('title')
    Edit User {{$item->name}}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.data.user.update', $item->id)}}" method="POST">
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
                    <label for="" class="form-label">Target</label>
                    <input type="number" class="form-control @error('target') is-invalid @enderror" name="target" required value="{{$item->target}}">
                    @error('target')
                        <small class="text-danger">
                            <i>{{$message}}</i>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  >
                    <small class="text-danger"><i>Kosongkan jika tidak ingin diubah</i></small>
                </div>

                 {{-- alamat --}}
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Provinsi</label>
                        <select required name="provinsi" id="provinsi" class="form-select">
                            <option >Pilih Provinsi</option>
                            @foreach ($provinsi as $itemProv)
                                <option value="{{$itemProv->id_provinsi}}" {{$item->provinsi_id === $itemProv->id_provinsi ? 'selected' : ''}}>{{$itemProv->nama}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Kota/Kabupaten</label>
                        <select required name="kota" id="kota" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Kecamatan</label>
                        <select required name="kecamatan" id="kecamatan" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Desa</label>
                        <select required name="desa" id="desa" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-12">
                        <textarea name="alamat" class="form-control">{{$item->alamat}}</textarea>
                    </div>
                </div>
                {{-- alamat end --}}

                <button type="submit" class="btn btn-warning">Simpan Data</button>
            </form>
        </div>
    </div>
@endsection

@push('addScript')

<script>
    $.ajax({
        url: `{{route('listKota')}}?provinsi={{$item->provinsi_id}}`,
        type: "GET",
        success: function(data){
            let tagHtml = "<option >Pilih kota</option>";

            let tempData = data.data;
            tempData.forEach(element => {
                tagHtml += `<option value="${element.id_kota}" ${element.id_kota === {{(int)$item->kota_id}} ? 'selected' : '' }>${element.nama}</option>`
            });

            $("#kota").html(tagHtml);


        },
        error: function(err){
            console.log('err', err)
        }
    })

    $.ajax({
        url: `{{route('listKecamatan')}}?kota={{$item->kota_id}}`,
        type: "GET",
        success: function(data){
            let tagHtml = "<option >Pilih kecamatan</option>";

            let tempData = data.data;
            tempData.forEach(element => {
                tagHtml += `<option value="${element.id_kecamatan}" ${element.id_kecamatan === {{(int)$item->kecamatan_id}} ? 'selected' : '' }>${element.nama}</option>`
            });

            $("#kecamatan").html(tagHtml);


        },
        error: function(err){
            console.log('err', err)
        }
    })

    $.ajax({
        url: `{{route('listDesa')}}?kecamatan={{$item->kecamatan_id}}`,
        type: "GET",
        success: function(data){

            let tagHtml = "<option >Pilih Desa</option>";

            let tempData = data.data;
            tempData.forEach(element => {
                tagHtml += `<option value="${element.id}" ${element.id === {{(int)$item->desa_id}} ? 'selected' : '' }>${element.nama}</option>`
            });

            $("#desa").html(tagHtml);


        },
        error: function(err){
            console.log('err', err)
        }
    })
</script>

<script>
        $("#provinsi").on("change", function(){
            let value = $(this).val();

            $.ajax({
                url: `{{route('listKota')}}?provinsi=${value}`,
                type: "GET",
                success: function(data){
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
        $("#kecamatan").on("change", function(){
            let value = $(this).val();

            $.ajax({
                url: `{{route('listDesa')}}?kecamatan=${value}`,
                type: "GET",
                success: function(data){
                    console.log('data', data.data)
                    let tagHtml = "<option >Pilih Desa</option>";

                    let tempData = data.data;
                    tempData.forEach(element => {
                        tagHtml += `<option value="${element.id}">${element.nama}</option>`
                    });

                    $("#desa").html(tagHtml);


                },
                error: function(err){
                    console.log('err', err)
                }
            })
        })
</script>
@endpush
