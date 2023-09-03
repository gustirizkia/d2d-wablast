@extends('layouts.admin')

@section('title')
    Edit DAPIL {{$item->title}}
@endsection

@push('addStyle')
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush

@section('content')
<form action="{{route('admin.real-count.dapil.update', $item->uuid)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="" >
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">Gambar/Thumbnail</label>
                    <input type="file" class="form-control" name="image">
                    <small class="text-secondary">Kosongkan jika tidak ingin ganti</small>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nama DAPIL</label>
                    <input type="text" class="form-control" value="{{$item->title}}" name="nama_dapil">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="" cols="30" rows="4" class="form-control">{{$item->deskripsi}}</textarea>
                </div>
            </div>
        </div>

        @foreach ($item->caleg as $index => $caleg)
            @php
                $i = $index+1;
            @endphp
            <div id="caleg_data">
                <div class="card my-4 caleg_{{$index}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Calon</label>
                                    <input type="text" name="caleg[{{$index}}][nama]" value="{{$caleg->nama}}" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Calon</label>
                                    <input type="number" name="caleg[{{$index}}][nomor]" value="{{$caleg->nomor}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="btn btn-danger remove_caleg" onclick="removeData({{$index}})">
                                <i class="bi bi-trash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach




        <div class="text-center mb-5">
            <button type="button" class="btn-outline-warning btn add_caleg">Tambah Kandidat Calon</button>
        </div>

        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>
@endsection


@push('addScript')
    <script>
        let i = {{$i}};
       $(".add_caleg").on("click", function(){
             ++i;
            let tagHtml = `
                <div class="card my-4 caleg_${i}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Calon</label>
                                    <input type="text" name="caleg[${i}][nama]" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Calon</label>
                                    <input type="number" name="caleg[${i}][nomor]" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="btn btn-danger remove_caleg" onclick="removeData(${i})">
                                <i class="bi bi-trash"></i>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $("#caleg_data").append(tagHtml);
       })

       function removeData(id){
            console.log('id', id)
            $(`.caleg_${id}`).remove();
       }

    </script>
@endpush

