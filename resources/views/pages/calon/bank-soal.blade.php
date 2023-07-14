@extends('layouts.admin')

@section('title')
    Bank Soal Calon {{$item->nama}}
@endsection

@push('addStyle')
    <style>
        .modal-body {
            height: 500px;
            overflow-y: scroll;
        }
    </style>
@endpush

@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{route('admin.insertSoalCalon')}}" method="post">
        @csrf
        <input type="number" name="calon" value="{{$item->id}}" hidden>
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Pertanyaan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center loading">
                <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="fw-bold mt-2">Loading <br> mengambil data</div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning">Save changes</button>
          </div>
        </div>
    </form>
  </div>
</div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4 text-end">
                <div class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Data</div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Pertanyaan</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($item->hasSoal as $index => $has)
                            <tr>
                                <td>
                                    {{$index+1}}
                                </td>
                                <td>{{$has->soal->title}}</td>
                                <td>
                                    <form action="{{route("admin.deleteHasSoal", $has->id)}}">

                                        <div class="btn btn-danger delete_confirm">Hapus</div>
                                    </form>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('addScript')
    <script>
        $.ajax({
            url: "{{route("admin.getSoal", $item->id)}}",
            type: "GET",
            success: function(data){
                let tagHtml = '';
                data.forEach(element => {
                    tagHtml += `
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="soal_id[]" value="${element.id}" id="flexCheckDefault${element.id}">
                                <label class="form-check-label" for="flexCheckDefault${element.id}">
                                    ${element.title}
                                </label>
                            </div>
                    `;
                });

                $(".modal-body").html(tagHtml);
                $(".loading").hide();

            },
            error: function(err){
                console.log('err', err)
            }
        })
    </script>
@endpush
