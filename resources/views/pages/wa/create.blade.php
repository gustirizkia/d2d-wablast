@extends('layouts.admin')

@section('title')
    Tambah Wa Blast
@endsection

@push('addStyle')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        .add_pilihan{
            position: absolute;
            top: 0;
            right: 0;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="card" x-data="funcData">
        <div class="card-body">
            <form action="{{ route("admin.wa.store") }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Message</label>
                        <textarea name="message" id="" cols="30" rows="4" class="form-control" required>{{ old('message') }}</textarea>
                    </div>
                </div>

                <hr>

                <div class="row mt-5">
                    <div class="mb-3 col-md-12">
                        <div class="text-center h3">Pilih jawaban yang akan menerima pesan otomatis</div>
                    </div>

                </div>

                <div class="row">
                    @foreach ($soals as $soal)
                        <div class="col-12 mb-4">
                            <label for="" class="form-label">{{ $soal->title }}</label>
                            @if ($soal->yes_no)
                                <div class="form-check">
                                    <input class="form-check-input" name="jawaban_iya_tidak[{{ $soal->id }}]" type="checkbox" value="ya" id="flexCheckDefault{{ $soal->id }}_ya">
                                    <label class="form-check-label" for="flexCheckDefault{{ $soal->id }}_ya">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="jawaban_iya_tidak[{{ $soal->id }}]" type="checkbox" value="tidak" id="flexCheckDefault{{ $soal->id }}_tidak">
                                    <label class="form-check-label" for="flexCheckDefault{{ $soal->id }}_tidak">
                                        Tidak
                                    </label>
                                </div>
                            @else
                                @foreach ($soal->pilihan as $pilihan)
                                    <div class="form-check">
                                        <input class="form-check-input" name="jawaban_id[]" type="checkbox" value="{{ $pilihan->id }}" id="flexCheckDefault{{ $soal->id }}_{{ $pilihan->id }}">
                                        <label class="form-check-label" for="flexCheckDefault{{ $soal->id }}_{{ $pilihan->id }}">
                                            {{ $pilihan->title }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('addScript')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        function funcData(){
            return{
                type: "text",
                message: null,
                image: {
                    preview: null,
                    file: null
                },

                handelSubmit(){
                    let msgError = null;

                    if(this.message === null){
                        msgError = "Pesan belum di isi"
                    }
                },
            }
        }
    </script>
@endpush
