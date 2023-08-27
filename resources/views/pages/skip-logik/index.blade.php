@extends('layouts.admin')

@section('title')
    Skip Logik
@endsection

@section('content')

@if ($skip_soal)
    @include('pages.skip-logik._edit-soal')
@else
    @include('pages.skip-logik.add-soal')
@endif
@endsection


