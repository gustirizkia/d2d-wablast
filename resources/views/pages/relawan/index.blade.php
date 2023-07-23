@extends('layouts.admin')

@section('title')
    Relawan
@endsection

@push('addStyle')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-end mb-4">

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
                                    <a href="/admin/data/relawan" class="btn btn-warning">Reset</a>
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

            <div class="mt-5">
                {{$items->links("pagination::bootstrap-5")}}
            </div>
        </div>
    </div>

    @include('pages.components._statistik-relawa')


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
