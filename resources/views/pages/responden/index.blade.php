@extends('layouts.admin')

@section('title')
    Responden
@endsection

@push('addStyle')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between mb-4">
                <div class="col-md-2 mb-3">
                    <a href="{{route('admin.responden-export')}}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet-fill"></i><span class="ms-2">Export</span></a>
                </div>
                <div class="col-md-12">
                    <form action="">
                        <div class="d-flex justify-content-end">
                            <div class="">
                                <input type="date" class="form-control" placeholder="Start Date" value="{{request()->get("start_date")}}" name="start_date">
                            </div>
                            <div class="ms-3">
                                <input type="date" class="form-control" placeholder="End Date" value="{{request()->get("end_date")}}" name="end_date">
                            </div>
                            <div class="ms-3">
                                <select name="surveyor" id="" class="form-select">
                                    <option value="">Survoyer</option>
                                    @foreach ($users as $item)
                                        <option value="{{$item->id}}" {{(int)request()->get('surveyor') === $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="ms-3">

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
                                @if (request()->get("provinsi") || request()->get("kota") || request()->get("kecamatan") || (int)request()->get('surveyor') || request()->get("start_date") || request()->get("end_date"))
                                    <a href="/admin/data/responden" class="btn btn-outline-warning">Reset</a>
                                    <button class="btn btn-warning ms-2">Filter</button>
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
                        <th scope="col">Nama Surveyor</th>
                        <th scope="col">Nama Responden</th>
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
                                <td>{{$dataItem->user->name}}</td>
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

            <div class="mt-5">
                {{$items->links("pagination::bootstrap-5")}}
            </div>
        </div>
    </div>

    {{-- statistik  --}}
    <div class="mt-5">

        <div class="card loading_map" aria-hidden="true">
            <div class="card-body">
                <h5 class="card-title placeholder-glow">
                    <span class="placeholder col-3" style="height: 84px">
                        <div class="text-white d-flex align-items-center justify-content-center h-100">Loading data</div>
                    </span>
                    <span class="placeholder col-3" style="height: 84px">
                        <div class="text-white d-flex align-items-center justify-content-center h-100">Loading data</div>
                    </span>
                    <span class="placeholder col-3" style="height: 84px">
                        <div class="text-white d-flex align-items-center justify-content-center h-100">Loading data</div>
                    </span>
                </h5>
                <p class="card-text placeholder-glow">
                    <span class="placeholder col-3"></span>
                    <span class="placeholder col-3"></span>
                    <span class="placeholder col-3"></span>
                    <span class="placeholder col-3"></span>
                    <span class="placeholder col-3"></span>
                    <span class="placeholder col-3"></span>
                </p>
                <div tabindex="-1" class="btn btn-primary placeholder col-6"></div>
            </div>
        </div>

        <div class="row statistik" style="display: none">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border rounded me-3 p-2">
                                <div class="">Provinsi</div>
                                <div class="h2 mb-0" id="count_Provinsi">0</div>
                            </div>
                            <div class="col-md-3 border rounded me-3 p-2">
                                <div class="">Kota</div>
                                <div class="h2 mb-0" id="count_Kota">0</div>
                            </div>
                            <div class="col-md-3 border rounded me-3 p-2">
                                <div class="">Kecamatan</div>
                                <div class="h2 mb-0" id="count_Kecamatan">0</div>
                            </div>
                        </div>
                    <div id="chart-tasks-overview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 statistik" >
        <div id="mapid2" style="width: 100%; height: 500px;"></div>
    </div>
    {{-- statistik end --}}
@endsection

@push('addScript')

{{-- statistik --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
    var mymap2 = L.map('mapid2').setView([-6.2470928, 106.6501857], 11);

    $.ajax({
        url: "{{route('admin.data.responden-statistik')}}",
        type: "GET",
        success: function(data){
            let dataSeries = [];
            let dataLabel = [];
            data.responden.forEach(element => {
                dataSeries.push(element.total)
                dataLabel.push(element.rel_kecamatan.nama)
            });

            $("#count_Provinsi").text(data.count['provinsi'])
            $("#count_Kota").text(data.count['kota'])
            $("#count_Kecamatan").text(data.count['kecamatan'])


            // chart
            var options = {
            series: [{
                name: 'Jumlah',
                data: dataSeries
                }],
            annotations: {
            points: [{
                x: 'Relawan',
                seriesIndex: 0,
                label: {
                offsetY: 0,

                text: 'Chart Statistik Relawan Perkecamatan',
                }
            }]
            },
            chart: {
            height: 350,
            type: 'bar',
            },
            plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: '50%',
            }
            },
            dataLabels: {
            enabled: false
            },
            stroke: {
            width: 2
            },

            grid: {

            },
            xaxis: {
            labels: {
                rotate: -45
            },
            categories: dataLabel,
            tickPlacement: 'on'
            },
            yaxis: {
            title: {
                text: 'Statistik Diagram Relawan',
            },
            },
            fill: {
            // type: 'gradient',
            // gradient: {
            //     shade: 'light',
            //     type: "horizontal",
            //     shadeIntensity: 0.25,
            //     gradientToColors: undefined,
            //     inverseColors: true,
            //     opacityFrom: 0.85,
            //     opacityTo: 0.85,
            //     stops: [50, 0, 100]
            // },
            }
            };

            var chart = new ApexCharts(document.querySelector("#chart-tasks-overview"), options);
            chart.render();
            // chart end

            // map
            data.all_responden.forEach(element => {
                marker = new L.marker([element.latitude, element.longitude])
                .bindPopup(element.nama)
                .addTo(mymap2);
            });

            let layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 100,
                zoomSnap: 5,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(mymap2);
            // map end

            $(".loading_map").hide();
            $(".statistik").show();

        },
        error: function(err){
            console.log('err', err)
        }
    })
{{-- statistik end --}}

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
