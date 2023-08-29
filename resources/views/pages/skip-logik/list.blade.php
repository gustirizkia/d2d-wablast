@extends('layouts.admin')

@section('title')
    Skip Logik {{$soal->title}}
@endsection

@section('content')

@php
    $first_skip_soal = null;
    if(count($skip_soal)){
        $first_skip_soal = $skip_soal[0];
    }

@endphp

<div class="card mb-5">
    <div class="card-body">
        <div class="h3">{{$soal->title}}</div>
        <form action="{{route("admin.data.storePilihanSkip")}}" method="post">
            @csrf
            <input type="number" name="soal" value="{{$soal->id}}" hidden>
            <label for="" class="form-label">Pilih jawaban untuk di skip</label>

            @if ($soal->yes_no)

                @if ($first_skip_soal)
                    <div class="form-check">
                        <input class="form-check-input skip_input" value="iya" {{$first_skip_soal->skip_if_yes_no !== 'tidak' ? "checked" : ''}} type="radio" name="pilihan" id="flexRadioDefault_iya">
                        <label class="form-check-label" for="flexRadioDefault_iya">
                            Iya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input skip_input" {{$first_skip_soal->skip_if_yes_no === 'tidak' ? "checked" : ''}} value="tidak" type="radio" name="pilihan" id="flexRadioDefault_tidak">
                        <label class="form-check-label" for="flexRadioDefault_tidak">
                            Tidak
                        </label>
                    </div>
                @else
                    <div class="form-check">
                        <input class="form-check-input skip_input" value="iya" type="radio" name="pilihan" id="flexRadioDefault_iya">
                        <label class="form-check-label" for="flexRadioDefault_iya">
                            Iya
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input skip_input"  value="tidak" type="radio" name="pilihan" id="flexRadioDefault_tidak">
                        <label class="form-check-label" for="flexRadioDefault_tidak">
                            Tidak
                        </label>
                    </div>

                @endif
            @else
                @foreach ($pilihan as $item)
                    @if ($first_skip_soal)
                        <div class="form-check">
                            <input class="form-check-input skip_input" value="{{$item->id}}" type="radio" name="pilihan" id="flexRadioDefault{{$item->id}}" {{$first_skip_soal->skip_if_pilihan_id === $item->id ? 'checked' : ''}}>
                            <label class="form-check-label" for="flexRadioDefault{{$item->id}}">
                                {{$item->title}}
                            </label>
                        </div>
                    @else
                        <div class="form-check">
                            <input class="form-check-input skip_input" value="{{$item->id}}" type="radio" name="pilihan" id="flexRadioDefault{{$item->id}}">
                            <label class="form-check-label" for="flexRadioDefault{{$item->id}}">
                                {{$item->title}}
                            </label>
                        </div>
                    @endif
                @endforeach

            @endif

            <button class="btn btn-primary mt-3" type="submit">Simpan Pilihan Untuk Skip</button>

        </form>

    </div>
</div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                @if ($first_skip_soal)
                    <a href="{{route("admin.data.tambahData-skip", $soal->id)}}" class="btn btn-outline-primary mb-3">Tambah Data</a>
                @endif
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Pertanyaan</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Jenis Pilihan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skip_soal as $item)
                        <tr>
                            {{-- {{dd($item)}} --}}
                            <td>{{$item->title}}</td>
                            <td>{{$item->subtitle}}</td>
                            <td>{{$item->yes_no ? "Hanya iya atau tidak" : "Form Custom"}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route("admin.data.editSkipSoal", [$soal->id, $item->id])}}" class="btn btn-primary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


