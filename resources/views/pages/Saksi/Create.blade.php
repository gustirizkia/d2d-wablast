@extends('layouts.admin')

@section('title')
    Tambah Saksi
@endsection

@push('addStyle')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

@endpush

@section('content')
    <div class="card" >
        <div class="card-body">
            @include('pages.Saksi._modal-surveyor')
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#modalSurveyor">
                        Ambil Dari Surveyor
                    </button>

                </div>
            </div>

            <form action="{{route('admin.real-count.saksi.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control nama @error('name')is-invalid @enderror" name="name" required value="{{old('name')}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Username</label>
                        <input type="text" class="form-control username @error('username')is-invalid @enderror" name="username" required value="{{old('username')}}">
                        @error('username')
                            <small class="text-danger">
                                <i>{{$message}}</i>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email')is-invalid @enderror" name="email" required value="{{old('email')}}">
                    @error('email')
                        <small class="text-danger">
                            <i>{{$message}}</i>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nomor Telepon</label>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" required value="{{old('phone')}}">
                    @error('phone')
                        <small class="text-danger">
                            <i>{{$message}}</i>
                        </small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required value="{{old('password')}}">
                </div>

                {{-- alamat --}}
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Provinsi</label>
                        <select required name="provinsi" id="provinsi" class="form-select">
                            <option >Pilih Provinsi</option>
                            @foreach ($provinsi as $item)
                                <option value="{{$item->id_provinsi}}">{{$item->nama}}</option>
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
                        <label for="" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control">{{old('alamat')}}</textarea>
                    </div>
                </div>
                {{-- alamat end --}}

                <div class="mb-3">
                    <label for="" class="form-label">Dapil</label>
                    <select name="dapil" id="" class="form-select">
                        <option >Pilih Dapil</option>
                        @foreach ($dapil as $item)
                            <option value="{{$item->id}}" >{{$item->title}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="btn_submit btn btn-warning">Simpan Data</div>
            </form>
        </div>
    </div>
@endsection

@push('addScript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
    let kota = [
        @foreach($listKota as $item)
        {
            id: {{$item->id}},
            nama: "{{$item->nama}}",
            id_kota: {{$item->id_kota}}
        },
        @endforeach
    ];
    let optionKecamatan = '<option>Pilih Kota/Kabupaten</option>';

    kota.forEach(element => {
        optionKecamatan += `<option value="${element.id_kota}">${element.nama}</option>`;
    });

    $(".target").on("input", function(){
       let value = $(this).val();
        pushSelect(value)
    });

    $(".btn_submit").on("click", function(){
        let list_kota_count = $(".list_kota").val();

        $("form").submit();

        console.log('list_kota_count', list_kota_count)
    })

        $(".nama").on("input", function(){
            let value = $(this).val();
            value = value.split(" ").join("")
            value = value.toLowerCase();

            $(".username").val(value);
        });

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


