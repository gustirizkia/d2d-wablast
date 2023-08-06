@extends('layouts.admin')

@section('title')
    Kuisioner
@endsection

@section('content')
{{-- {{dd($filter)}}; --}}
<a href="{{route('admin.data.bank-soal.create')}}" class="mb-4 btn btn-warning">Tambah Data</a>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pertanyaan</th>
                        <th scope="col">Notes/Deskripsi</th>
                        <th scope="col">Jenis Pilihan</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['soal'] as $index => $item)
                            <tr>
                                <th scope="row">{{$index+1}}</th>
                                <td>{{$item->title}}</td>
                                <td>{{$item->subtitle}}</td>
                                <td>{{$item->yes_no ? "Hanya iya atau tidak" : "Form Custom"}}</td>
                                <td>
                                    @if ($item->soal_kecamatan)
                                        <span class="soal_kecamatan{{$item->id}}">loading</span>
                                    @else
                                        <span class="text-warning">
                                            General
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('admin.data.bank-soal.edit', $item->id)}}" class="btn btn-warning">Edit</a>
                                        <a href="{{ route('admin.data.tambahData-skip', $item->id) }}" class="btn btn-info ms-2">Skip Logic</a>
                                        <form action="{{route('admin.data.bank-soal.destroy', $item->id)}}" method="post">
                                            @csrf
                                            @method("DELETE")

                                            <span class="btn btn-outline-danger ms-2 delete_confirm">Delete</span>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{$data['soal']->links("pagination::bootstrap-5")}}
        </div>
    </div>
@endsection

@push('addScript')

<script>
    let tempSoalKecamatan = [
        @foreach($data['soal'] as $soal)
            @if ($soal->soal_kecamatan)
                {
                    id: {{$soal->id}},
                    kecamatan_id: {{$soal->soal_kecamatan->kecamatan_id}}
                },
            @endif
        @endforeach
    ];

    tempSoalKecamatan.forEach(element => {
        $.ajax({
            url: `/admin/getKecamatanById/${element.kecamatan_id}`,
            type: "GET",
            success: function(data){
                $(".soal_kecamatan"+element.id).text(`${data.kota.nama}, ${data.nama}`)
            },
            error: function(err){
                console.log('err', err)
            }
        });
    });


</script>

<script>
    $(".filter_btn").click(function(){
        $("#form_filter").submit();
    });

    $(".filter_pilihan").on("change", function(){
        let key_id = $(this).attr("id");
        let value = $(this).val();

        console.log('value', value)
        console.log('key_id', key_id)
    })


</script>


    <script>
        $('.delete_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: `Hapus data`,
                // text: "If you delete this, it will be gone forever.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
