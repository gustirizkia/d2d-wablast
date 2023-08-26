@extends('layouts.admin')

@section('title')
    Saksi
@endsection

@section('content')
    <div class="card" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('admin.real-count.saksi.create')}}" class="btn btn-warning">Tambah Data</a>
                </div>
            </div>
        </div>
    </div>
@endsection
