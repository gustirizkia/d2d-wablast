@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset('icon/archive.png')}}" alt="" class="img-fluid" style="width: 50px">
                    <div class="h3 mb-0">
                        Real Qount
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset('icon/online-survey.png')}}" alt="" class="img-fluid" style="width: 50px">
                    <div class="h3 mb-0">
                        Survey Online
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset('icon/support.png')}}" alt="" class="img-fluid" style="width: 50px">
                    <div class="h3 mb-0">
                        Relawan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="h3 mb-0">Relawan</div>
                    <div class="" style="font-size: 24px">{{$data["count_relawan"]}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="h3 mb-0">Surveyor</div>
                    <div class="" style="font-size: 24px">{{$data["count_surveyor"]}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="h3 mb-0">Responden</div>
                    <div class="" style="font-size: 24px">{{$data["count_responden"]}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="row">

            @foreach ($data['statistik_pilihans'] as $key => $item)
                <div class="col-md-4 ">
                    <div class="card">
                        <div class="card-header">{{$data['statistik_pilihans'][$key][0]->title_soal}}</div>
                        <div class="card-body">
                        <div id="pilihan{{$key}}"></div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

@include('pages.components._statistik-relawa')

@endsection

@push('addScript')



@endpush
