<table >
    <tr>
        <td style="background-color: #e3e3e3" colspan="6" valign="middle" width="30"><h1><b>Profile Responden</b></h1></td>
    </tr>
    <tr>
        <td style="background-color: #e3e3e3" colspan="6" valign="middle" width="30">Nama : {{$item->nama}}</td>
    </tr>
    <tr>
        <td valign="middle" width="30" style="background-color: #e3e3e3" colspan="6">Provinsi : {{$item->rel_provinsi->nama}}</td>
    </tr>
    <tr>
        <td valign="middle" width="30" style="background-color: #e3e3e3" colspan="6">Kota : {{$item->rel_kota->nama}}</td>
    </tr>
    <tr>
        <td valign="middle" width="30" style="background-color: #e3e3e3" colspan="6">Kecamatan : {{$item->rel_kecamatan->nama}}</td>
    </tr>
    <tr>
        <td valign="middle" width="30" style="background-color: #e3e3e3" colspan="6">Desa : {{$item->rel_desa->nama}}</td>
    </tr>
    <tr>
        <td valign="middle" width="30" style="background-color: #e3e3e3" colspan="6">Alamat : {{$item->alamat}}</td>
    </tr>
    <tr>
        <td valign="middle" width="30" style="background-color: #e3e3e3" colspan="6">Tanggal Survey : {{$item->created_at}}</td>
    </tr>

</table>

<table class="table">
    <thead>
        <tr>
        <th scope="col" style="border: 2px solid #9c9c9c"><b>Pertanyaan</b></th>
        <th scope="col" style="border: 2px solid #9c9c9c"><b>Jawaban</b></th>
        <th scope="col" style="border: 2px solid #9c9c9c"><b>Tanggal</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $dataItem)
            <tr>
                <td>{{$dataItem->soal->title}}</td>
                <td>{{$dataItem->yes_no ? $dataItem->yes_no : $dataItem->pilihan->title }}</td>
                <td>{{$dataItem->created_at }}</td>
            </tr>
        @empty

        @endforelse
    </tbody>
</table>
