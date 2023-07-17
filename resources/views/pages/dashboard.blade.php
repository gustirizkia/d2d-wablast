@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="h3 mb-0">Relawan</div>
                    <div class="" style="font-size: 24px">{{$data["count_relawan"]}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="h3 mb-0">Surveyor</div>
                    <div class="" style="font-size: 24px">{{$data["count_surveyor"]}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="h3 mb-0">Responden</div>
                    <div class="" style="font-size: 24px">{{$data["count_responden"]}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="row">

            @foreach ($data['statistik_pilihans'] as $key => $item)
                <div class="col-md-4 ">
                    <div class="card">
                        <div class="card-header">{{$data['statistik_pilihans'][$key][0]->title_soal}}</div>
                        <div class="card-body">
                        <div id="pilihan{{$key}}"></div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">Statistik Relawan</div>
                  <div class="card-body">
                    <div id="chart-completion-tasks-3"></div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addScript')


    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-completion-tasks-3'),


        {
            series: [{
                name: "Relawan daftar",
                data: [
                    @foreach($data['statistik_relawan'] as $value)
                        {{$value->total}},
                    @endforeach
                ]
            }],
            chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
            },
            dataLabels: {
            enabled: false
            },
            stroke: {
                width: 2,
      			lineCap: "round",
      			curve: "smooth",
            },
            title: {
                text: 'Relawan by Week',
                align: 'left'
            },
            grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
            },
            xaxis: {
                categories: false,
                labels:{
                    show: false
                }
            }
        }

        )).render();

        // $("text").hide()
      });
      // @formatter:on
    </script>

    @foreach ($data['statistik_pilihans'] as $key => $item)
        <script>
            var colors = [
                '#008FFB',
                '#00E396',
                '#FEB019',
                '#FF4560',
                '#775DD0',
                '#546E7A',
                '#26a69a',
                '#D10CE8'
            ]

            document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('pilihan{{$key}}'), {
                series: [{
                data: [
                    @foreach($data['statistik_pilihans'][$key] as $value)
                    {{$value->count}},
                    @endforeach
                ]
                }],
                chart: {
                height: 350,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                    // console.log(chart, w, e)
                    }
                }
                },
                colors: colors,
                plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
                },
                dataLabels: {
                enabled: false
                },
                legend: {
                show: false
                },
                xaxis: {
                categories: [
                    @foreach($data['statistik_pilihans'][$key] as $value)
                        ['{{$value->title_pilihan}}'],
                    @endforeach
                ],
                labels: {
                    style: {
                    colors: colors,
                    fontSize: '12px'
                    }
                }
                }
            })).render();
        });
        </script>

    @endforeach
@endpush
