<table class="table">
    <thead>
        <tr>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Nama Surveyor</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Nama Responden</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Alamat</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Provinsi</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Kota</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Kecamatan</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Desa</b></th>
        <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16"><b>Tanggal Survey</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $dataItem)
            <tr>
                <td>{{$dataItem->user->name}}</td>
                <td>{{$dataItem->nama}}</td>
                <td>{{$dataItem->alamat}}</td>
                <td>{{$dataItem->rel_provinsi->nama}}</td>
                <td>{{$dataItem->rel_kota->nama}}</td>
                <td>{{$dataItem->rel_kecamatan->nama}}</td>
                <td>{{$dataItem->rel_desa->nama}}</td>
                <td>{{$dataItem->created_at}}</td>

            </tr>
        @empty
            <tr>
                <td colspan="20">
                    <div class="text-center">
                        <div class="fw-bold">Tidak ada data</div>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
