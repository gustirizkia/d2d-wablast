@extends('layouts.admin')

@section('title')
    Lokasi Survey
@endsection

@push('addStyle')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="">
                <div id="mapid" style="width: 100%; height: 400px;"></div>
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


        var locations = [
            @foreach($data as $item)
            ["{{$item->nama}}", {{$item->latitude}}, {{$item->longitude}}],
            @endforeach
        ];

        var mymap = L.map('mapid').setView([-6.2470928, 106.6501857], 12);


        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 100,
            zoomSnap: 5,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mymap);

        for (var i = 0; i < locations.length; i++) {
        marker = new L.marker([locations[i][1], locations[i][2]])
            .bindPopup(locations[i][0])
            .addTo(mymap);
        }

        @foreach($dataUser as $item)
            getAlamat({{$item->id}}, {{$item->latitude}}, {{$item->longitude}})
        @endforeach

        function getAlamat(id, lat, long){
            $.ajax({
                url: `https://geocode.maps.co/reverse?lat=${lat}&lon=${long}`,
                type: "GET",
                success: function(data){
                    console.log('data', data)
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
