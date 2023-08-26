@extends('layouts.admin')

@section('title')
    Tambah Saksi
@endsection

@push('addStyle')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

@endpush

@section('content')
    <div class="card" >
        <div class="card-body">
            @include('pages.Saksi._modal-surveyor')
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSurveyor">
                        Ambil Dari Surveyor
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('addScript')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
@endpush


