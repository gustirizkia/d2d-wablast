@extends('layouts.admin')

@section('title')
    Grafik Kuisioner
@endsection

@section('content')
{{-- {{$data->links("pagination::bootstrap-5")}} --}}
@foreach ($data as $itemData)
    @if(count($itemData->pilihan) > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{$itemData->title}}
                    </div>
                    <div class="card-body">
                        <div class="" id="chart{{$itemData->id}}"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
{{-- {{$data->links("pagination::bootstrap-5")}} --}}
@push('addScript')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @foreach ($data as $item)
                @if(count($item->pilihan) > 0)

                    var options = {
                    series: [{
                        name: '{{$item->title}}',
                        data: [
                            @foreach($item->pilihan as $pilihan)
                                {{(int)$pilihan->pilihan_target_count}},
                            @endforeach
                        ]
                    }],
                    annotations: {
                    points: [{
                        x: '{{$item->title}}',
                        seriesIndex: 0,
                        label: {
                        borderColor: '#775DD0',
                        offsetY: 0,
                        style: {
                            color: '#fff',
                            background: '#775DD0',
                        },
                        text: '{{$item->title}}',
                        }
                    }]
                    },
                    chart: {
                    height: 350,
                    type: 'bar',
                    },
                    plotOptions: {
                    bar: {
                        borderRadius: 10,
                        columnWidth: '50%',
                    }
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    width: 2
                    },

                    grid: {
                    row: {
                        colors: ['#fff', '#f2f2f2']
                    }
                    },
                    xaxis: {
                    labels: {
                        rotate: -45
                    },
                    categories: [@foreach($item->pilihan as $pilihan)
                                "{{$pilihan->title}}",
                            @endforeach
                    ],
                    tickPlacement: 'on'
                    },
                    yaxis: {
                    title: {
                        text: 'Grafik',
                    },
                    },
                    fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 0.85,
                        opacityTo: 0.85,
                        stops: [50, 0, 100]
                    },
                    }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart{{$item->id}}"), options);
                    chart.render();
                @endif
            @endforeach

        })
    </script>
@endpush
