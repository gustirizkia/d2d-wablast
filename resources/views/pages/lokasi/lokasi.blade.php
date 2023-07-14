@extends('layouts.admin')

@section('title')
    Lokasi Survey
@endsection

@push('addStyle')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <style>
        .icons{
            height: 16px;
            width: 16px;
            background-color: rgb(239, 6, 57);
            border-radius: 1000px;
            border: 1px solid black;
            display: block;
        }
     </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="mt-5">
                <div id="mapid2" style="width: 100%; height: 500px;"></div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">

                    <div class="form-floating">
                        <select class="form-select" id="soal" aria-label="Floating label select example" fdprocessedid="srkiig">
                            <option >Pilih</option>
                            @foreach ($soal as $item)
                                <option value="{{$item->id}}" class="circle_soal" >{{$item->title}}</option>
                            @endforeach
                        </select>
                        <label for="soal">Pertanyaan</label>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-floating">
                        <select class="form-select" id="jawaban" aria-label="Floating label select example" fdprocessedid="srkiig">
                            <option >Pilih</option>
                        </select>
                        <label for="jawaban">Jawaban</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="card">
            <div class="card-body">
                <div class="h4">Survey Terbaru</div>
                @foreach ($dataUser as $item)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div>
                                <div>
                                    <div class="fw-bold">
                                        Nama Surveyer
                                    </div>
                                    <div class="">
                                        {{$item->name}}
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="fw-bold">
                                        Nama Target
                                    </div>
                                    <div>{{$item->nama}}</div>
                                </div>
                                <div class="mt-2">
                                    <div class="fw-bold">Alamat</div>
                                    <div>{{$item->alamat}}</div>
                                </div>
                                <div class="mt-2">
                                    <div class="fw-bold">Alamat Berdasarkan Pin Lokasi</div>
                                    <div class="id_alamat{{$item->id}}" style="font-size: 12px;"></div>
                                </div>
                                <div class="mt-2">
                                    <div class="fw-bold">Waktu</div>
                                    <div class="">{{$item->updated_at}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endsection

@push('addScript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script>



        // pilihan

        var pilihan = [
            @foreach($pilihanTarget as $item)
            ["{{$item->nama}}", {{$item->latitude}}, {{$item->longitude}}, "{{$item->title}}"],
            @endforeach
        ];

        var mymap2 = L.map('mapid2').setView([-6.2470928, 106.6501857], 11);

        for (var i = 0; i < pilihan.length; i++) {

           marker = new L.marker([pilihan[i][1], pilihan[i][2]])
            .bindPopup(pilihan[i][3])
            .addTo(mymap2);
        }



        let layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 100,
            zoomSnap: 5,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mymap2);


        let itemPilihan = null;
        $("#soal").on("change", function(){
            let value = $(this).val();

            $.ajax({
                url : `/admin/detailSoal/${value}`,
                type: "GET",
                success: function(data)
                {
                    console.log('data', data)

                    let tempData = data;

                    itemPilihan = tempData;

                    let tagOption = '<option>Pilih</option>';
                    tempData.forEach(element => {

                        tagOption += `<option value="${element.id}">${element.title}</option>`
                    });

                    $("#jawaban").html(tagOption);
                },
                error: function(err){
                    console.log('err', err)
                }
            })
        })


        $("#jawaban").on("change", function(){
            let value = $(this).val();



            if(itemPilihan){
                itemPilihan.forEach(element => {
                    if(element.id === parseInt(value)){
                        mymap2.remove();

                        mymap2 = L.map('mapid2').setView([-6.2470928, 106.6501857], 11);
                        console.log('element', element)
                        element.pilihan_target.forEach(target => {
                            var myIcon = L.divIcon({
                                            className: 'custom-div-icon',
                                            html: `<div class='marker-pin'></div><span class='icons' style='background-color: #${element.soal.color}'></span>`,
                                            iconSize: [30, 42],
                                            iconAnchor: [15, 42]
                                        });


                            let data_target = target.data_target;
                            marker = new L.marker([data_target.latitude, data_target.longitude], {icon: myIcon})
                                    // .bindPopup()
                                    .addTo(mymap2);
                        })

                        let layer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 100,
                                        zoomSnap: 5,
                                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                    }).addTo(mymap2);
                    }
                });
            }

        })

        // end pilihan


        @foreach($dataUser as $item)
            getAlamat({{$item->id}}, {{$item->latitude}}, {{$item->longitude}})
        @endforeach

        function getAlamat(id, lat, long){
            $.ajax({
                url: `https://geocode.maps.co/reverse?lat=${lat}&lon=${long}`,
                type: "GET",
                success: function(data){
                    // console.log('data.display_name', data.display_name)
                    let address = data.display_name+" ";
                    address += data.address.postcode ? data.address.postcode : '';

                    $(`.id_alamat${id}`).text(address)
                },
                error: function(err){
                    console.log('err', err)
                }
            })
        }
    </script>
@endpush
