@extends('layouts.admin')

@section('title')
    DPT
@endsection

@section('content')
    {{-- Model import excel --}}
    <div class="modal fade" id="ImportExcelModal" tabindex="-1" aria-labelledby="ImportExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("admin.dpt.prosesImport") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ImportExcelModalLabel">Import Excel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="" class="form-label">Input File Excel</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Model import excel end --}}
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between mb-4">
                <div class="col-md-3">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ImportExcelModal">
                        Import Excel
                    </button>
                </div>
                <div class="col-md-4">
                    <form action="" method="get">
                        <div class="input-group ">
                            <input type="text" class="form-control" placeholder="Cari data" value="{{ request()->get("q") }}" name="q" aria-label="Cari data" aria-describedby="button-addon2">
                            <button class="btn btn-warning" type="submit" id="button-addon2">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Usia</th>
                        <th scope="col">Desa</th>
                        <th scope="col">Rw</th>
                        <th scope="col">Rt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <th scope="row">{{ $item->nama }}</th>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->usia }}</td>
                            <td>{{ $item->desa }}</td>
                            <td>{{ $item->rw }}</td>
                            <td>{{ $item->rt }}</td>
                        </tr>

                    @empty
                        <td colspan="12">
                            <div class="text-center">
                                Tidak ada data
                            </div>
                        </td>
                    @endforelse
                </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{$data->appends(request()->query())->links("pagination::bootstrap-5")}}
            </div>

        </div>
    </div>
@endsection
