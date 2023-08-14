@extends('layouts.admin')

@section('title')
    Skip Logik
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="h3">{{$soal->title}}</div>

            <label for="" class="form-label">Pilih jawaban untuk di skip</label>
            @if ($soal->yes_no)
                <div class="form-check">
                    <input class="form-check-input skip_input" value="iya" type="radio" name="skip" id="flexRadioDefault_iya">
                    <label class="form-check-label" for="flexRadioDefault_iya">
                        Iya
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input skip_input" value="tidak" type="radio" name="skip" id="flexRadioDefault_tidak">
                    <label class="form-check-label" for="flexRadioDefault_tidak">
                        Tidak
                    </label>
                </div>
            @else
                @foreach ($pilihan as $item)
                <div class="form-check">
                    <input class="form-check-input skip_input" value="{{$item->id}}" type="radio" name="skip" id="flexRadioDefault{{$item->id}}">
                    <label class="form-check-label" for="flexRadioDefault{{$item->id}}">
                        {{$item->title}}
                    </label>
                </div>
                @endforeach

            @endif
        </div>
    </div>

@if ($skip_soal)
    @include('pages.skip-logik._edit-soal')
@else
    @include('pages.skip-logik.add-soal')
@endif
@endsection


