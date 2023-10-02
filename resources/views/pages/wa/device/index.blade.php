@extends('layouts.admin')

@section('title')
    Number WhtasApp
@endsection

@section('content')

<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route("admin.wa.device.update", $item->serial) }}" method="post">
        @csrf
        @method("PUT")
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="EditModalLabel">Edit Nomor</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label for="" class="form-label">Nomor WhatsApp</label>
            <input type="number" class="form-control" required name="number" value="{{ $item->sender }}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </form>
  </div>
</div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">serial</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nomor</th>
                        <th scope="col">status</th>
                        <th scope="col">quota</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">{{ $item->serial }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->sender }}</td>
                        <td>{{ $item->status }} </td>
                        <td>{{ $item->quota }}</td>
                        <td>
                            <div class="dropdown  position-static">
                            <button class="btn btn-warning btn-sm " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><div class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditModal">Edit</div></li>
                                <li><a class="dropdown-item" href="#">Scan QR Code</a></li>
                            </ul>
                            </div>

                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
