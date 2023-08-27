<div class="card">
    <div class="card-body">
        <div class="h3">{{$soal->title}}</div>

        <label for="" class="form-label">Pilih jawaban untuk di skip</label>
        @if ($soal->yes_no)
            <div class="form-check">
                <input class="form-check-input skip_input" value="iya" type="radio" name="skip" id="flexRadioDefault_iya">
                <label class="form-check-label" for="flexRadioDefault_iya">
                    Iya
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input skip_input" value="tidak" type="radio" name="skip" id="flexRadioDefault_tidak">
                <label class="form-check-label" for="flexRadioDefault_tidak">
                    Tidak
                </label>
            </div>
        @else
            @foreach ($pilihan as $item)
            <div class="form-check">
                <input class="form-check-input skip_input" value="{{$item->id}}" type="radio" name="skip" id="flexRadioDefault{{$item->id}}">
                <label class="form-check-label" for="flexRadioDefault{{$item->id}}">
                    {{$item->title}}
                </label>
            </div>
            @endforeach

        @endif
    </div>
</div>


<div class="card mb-3 mt-4">
    <div class="card-body">
        <form action="{{route('admin.data.bank-soal.store')}}" method="post">
        @csrf
            <input type="number" hidden value="{{$soal->id}}" name="skip_soal">
            <input type="number" hidden value="" class="skip_if_pilihan_id" name="skip_if_pilihan_id">
            <input type="text" class="input_tipe_pilihan" value="mulitple" name="tipe_pilihan" hidden>
            <div class="row">
            <div class="col-md-6 mb-3">
                <div class="">
                    <label class="form-label">Soal</label>
                    <textarea class="form-control" required name="soal" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;"></textarea>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="">
                    <label class="form-label">Deskripsi/Notes <i>(optional)</i></label>
                    <textarea class="form-control" name="deskripsi" data-bs-toggle="autosize" placeholder="Type something…" style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 55.6px;"></textarea>
                </div>
            </div>
            </div>
            {{-- select type pilihan --}}
            <div class="card" id="pilihan_ganda">
                <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-home-1" class="nav-link active" tipe-pilihan="mulitple" data-bs-toggle="tab" aria-selected="true" role="tab">Form Custome</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-profile-1" class="nav-link" tipe-pilihan="ya_tidak" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Hanya Ya atau Tidak</a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabs-home-1" role="tabpanel">
                    {{-- data pilihan ganda --}}
                    <div class="pilihan">
                        <div class="mb-3">
                            <label for="" class="form-label">Pilihan 1</label>
                            <input type="text" placeholder="" name="pilihan[0]" class="form-control">
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <div class="btn btn-outline-warning add_pilihan">Tambah Pilihan</div>
                    </div>
                    {{-- end data pilihan ganda --}}
                    </div>
                    <div class="tab-pane" id="tabs-profile-1" role="tabpanel">
                    <h4>Hanya Iya atau Tidak</h4>
                    </div>
                </div>
                </div>
            </div>
            {{-- select type pilihan end --}}


            <div class="mt-5">
                <button class="btn btn-warning">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('addScript')
    <script>
        let i = 0;
        $(".add_pilihan").on("click", function(){
           i++;

           $(".pilihan").append(`
                <div class="mb-3">
                    <label for="" class="form-label">Pilihan ${i+1}</label>
                    <input type="text" placeholder="" required name="pilihan[${i}]" class="form-control">
               </div>
            `)
        });

        $("#pilihan_ganda .nav-link").on("click", function(){
            let tipe = $(this).attr("tipe-pilihan")

            $(".input_tipe_pilihan").val(tipe);
        })
    </script>
    @if ($soal->yes_no)
        <script>
            $(".skip_if_pilihan_id").attr("type", "text");
        </script>
    @endif

    <script>
        $(".skip_input").on("change", function(){
            let value = $(this).val();
            $(".skip_if_pilihan_id").val(value);
        })
    </script>
@endpush
