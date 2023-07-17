<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Responden</th>
                        <form action="" id="form_filter" method="GET">
                        @forelse ($data['soal'] as $key => $item)

                            <th scope="col">
                                {{$item->title}}

                                </th>
                            @empty
                            </form>

                        @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['responden'] as $index => $item)
                            <tr id="{{$index}}">
                                <th scope="row">
                                    <span style="font-size: 10px">{{ $item->nama }}</span>
                                </th>
                                @for ($i = 0; $i < count($data['soal']); $i++)
                                    <td>
                                        <span style="font-size: 10px">{{ $item->pilihanTarget->where("soal_id", $data['soal'][$i]->id)->first()->pilihan->title }}</span>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
