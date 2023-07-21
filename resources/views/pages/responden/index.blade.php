@extends('layouts.admin')

@section('title')
    Responden
@endsection

@section('content')
{{-- {{dd(request()->get('provinsi'))}} --}}
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between mb-4">
                <div class="col-md-3">
                    <a href="{{route('admin.responden-export')}}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet-fill"></i><span class="ms-2">Export</span></a>
                </div>
                <div class="col-md-8">
                    <form action="">
                        <div class="d-flex justify-content-end">
                            <div class="">
                                <select name="provinsi" id="provinsi" class="form-select">
                                    <option value="">Provinsi</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{$item->id_provinsi}}" {{(int)request()->get('provinsi') === $item->id_provinsi ? 'selected' : ''}}>{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="ms-3">
                                <select name="kota" id="kota" class="form-select">
                                    <option value="">Kota</option>
                                </select>
                            </div>
                            <div class="ms-3">
                                <select name="kecamatan" id="kecamatan" class="form-select">
                                    <option value="">Kecamatan</option>
                                </select>
                            </div>
                            <div class="ms-3">
                                @if (request()->get("provinsi") || request()->get("kota") || request()->get("kecamatan"))
                                    <a href="/admin/data/responden" class="btn btn-warning">Reset</a>
                                @else
                                    <button class="btn btn-warning">Filter</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Provinsi</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Desa</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $dataItem)
                            <tr>
                                <td>{{$dataItem->nama}}</td>
                                <td>{{$dataItem->alamat}}</td>
                                <td>{{$dataItem->rel_provinsi->nama}}</td>
                                <td>{{$dataItem->rel_kota->nama}}</td>
                                <td>{{$dataItem->rel_kecamatan->nama}}</td>
                                <td>{{$dataItem->rel_desa->nama}}</td>
                                <td>{{$dataItem->created_at}}</td>
                                <td>
                                    <a href="{{route('admin.data.responden.show', $dataItem->id)}}" class="btn btn-info">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="20">
                                    <div class="text-center">
                                        <div class="fw-bold">Tidak ada data</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('addScript')
    @if (request()->get('provinsi'))
        <script>
            $.ajax({
                    url: `{{route('listKota')}}?provinsi={{request()->get('provinsi')}}`,
                    type: "GET",
                    success: function(data){
                        console.log('data', data.data)
                        let tagHtml = "<option >Pilih kota</option>";

                        let tempData = data.data;
                        tempData.forEach(element => {
                            tagHtml += `<option value="${element.id_kota}" ${element.id_kota === {{(int)request()->get("kota")}} ? 'selected' : '' }>${element.nama}</option>`
                        });

                        $("#kota").html(tagHtml);


                    },
                    error: function(err){
                        console.log('err', err)
                    }
                })
        </script>
    @endif

    @if (request()->get("kota"))
        <script>
            $.ajax({
                    url: `{{route('listKecamatan')}}?kota={{request()->get("kota")}}`,
                    type: "GET",
                    success: function(data){
                        console.log('data', data.data)
                        let tagHtml = "<option >Pilih kecamatan</option>";

                        let tempData = data.data;
                        tempData.forEach(element => {
                            tagHtml += `<option value="${element.id_kecamatan}" ${ element.id === {{(int)request()->get("kota")}} ? '' : 'selected' }>${element.nama}</option>`
                        });

                        $("#kecamatan").html(tagHtml);


                    },
                    error: function(err){
                        console.log('err', err)
                    }
            })
        </script>
    @endif

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
