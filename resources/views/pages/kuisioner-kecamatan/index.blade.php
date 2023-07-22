@extends('layouts.admin')

@section('title')
    Kuisioner Perkecamatan
@endsection

@section('content')
<a href="{{route('admin.data.kuisioner-kecamatan.create')}}" class="btn btn-warning">Tambah Data</a>
<div class="mt-4">
    @foreach ($data['dataSoalKecamatan'] as $item)
        <div class="card mb-3">
            <div class="card-header">
                <div class="">
                    <div class="fw-bold">
                    {{$item->kota}}, {{$item->kecamatan}}
                    </div>
                    <div class="d-flex align-items-center" onclick="copyUrl('{{url("/survey?k=$item->kecamatan_id")}}',{{$item->kecamatan_id}})">
                        url : {{url("/survey?k=$item->kecamatan_id")}}
                        <span class="cp_df cp_df_{{$item->kecamatan_id}}"><i class="bi bi-clipboard ms-2"></i></span>
                        <span class="success_copy cp_{{$item->kecamatan_id}}" style="display: none"><i class="bi bi-clipboard-check-fill ms-2 text-success"></i></span>
                    </div>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="h4 mb-0">Jumlah Pertanyaan</div>
                        <div class="">{{$item->total_pertanyaan}}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="d-flex">
                        <a href="{{route('admin.data.kuisioner-kecamatan.edit', $item->kecamatan_id)}}" class="me-3 btn btn-warning">Edit</a>
                        <form action="{{route('admin.data.kuisioner-kecamatan.destroy', $item->kecamatan_id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <span class="btn btn-danger delete_confirm">Delete</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('addScript')

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

        function copyUrl(url, id){
            $(".success_copy").hide();
            $(".cp_df").show();

            $(`.cp_${id}`).show();
            $(`.cp_df_${id}`).hide();
            navigator.clipboard.writeText(url);
            console.log('id', id)
        }
    </script>
@endpush
