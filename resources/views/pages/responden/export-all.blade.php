<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table class="table">
    <thead>
        <tr>
            <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16">Responden</th>
            @foreach ($soal as $item)
                <th scope="col" style="background-color: #FFFBDB; border: 1px solid #000000;" width="16">{{$item->title}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTarget as $responden)
        <tr>
                <th scope="row">{{$responden->nama}}</th>
                @foreach ($soal as $itemSoal)
                    @if ($itemSoal->yes_no && $responden->pilihanTarget->where('soal_id', $itemSoal->id)->first())
                        <td>{{$responden->pilihanTarget->where('soal_id', $itemSoal->id)->first()->yes_no === 'iya' ? 'A. Iya' : "B. Tidak"}}</td>
                    @elseif ($responden->pilihanTarget->where('soal_id', $itemSoal->id)->first())

                        @php
                            $temp_indexAbjad = null
                        @endphp
                        @if ($responden->pilihanTarget->where('soal_id', $itemSoal->id)->first())
                            @foreach ($itemSoal->pilihan as $indexAbjad => $findAbjad)
                                @if ($responden->pilihanTarget->where('soal_id', $itemSoal->id)->first()->pilihan->id === $findAbjad->id)
                                    @php
                                        $temp_indexAbjad = $indexAbjad;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{$abjad[$temp_indexAbjad]}}. {{$responden->pilihanTarget->where('soal_id', $itemSoal->id)->first()->pilihan->title}}</td>
                        @else
                            <td>-</td>
                        @endif

                        @php
                            $indexAbjad = null
                        @endphp

                        {{-- <td>{{$responden->pilihanTarget->where('soal_id', $itemSoal->id)->first() ? $responden->pilihanTarget->where('soal_id', $itemSoal->id)->first()->pilihan->title : "-"}}</td> --}}
                    @else
                        <td>-</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
