@extends('layouts.admin')

@section('title')
    Report
@endsection

@section('content')
<div class="row">
    @foreach ($soal as $item)
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">{{$item->title}}</div>
                <div class="card-body">
                    <div class="" id="chart-completion-tasks{{$item->id}}"></div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="col-12 mt-5">
        {{$soal->links()}}
    </div>
</div>
@endsection

@push('addScript')
@foreach ($soal as $item)
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
      	window.ApexCharts && (new ApexCharts(document.getElementById('chart-completion-tasks{{$item->id}}'), {
      		chart: {
      			type: "bar",
      			fontFamily: 'inherit',
      			height: 340,
      			parentHeightOffset: 0,
      			toolbar: {
      				show: false,
      			},
      			animations: {
      				enabled: false
      			},
      		},
      		plotOptions: {
      			bar: {
      				columnWidth: '50%',
      			}
      		},
      		dataLabels: {
      			enabled: false,
      		},
      		fill: {
      			opacity: 1,
      		},
      		series: [{
      			name: "{{$item->title}}",
      			data: [
                      @foreach($item->statistikPilihan as $statistik)
                          {{$statistik->count}},
                      @endforeach
                ]
      		}],
      		tooltip: {
      			theme: 'dark'
      		},
      		grid: {
      			padding: {
      				top: -20,
      				right: 0,
      				left: -4,
      				bottom: -4
      			},
      			strokeDashArray: 4,
      		},
      		xaxis: {
      			labels: {
      				padding: 0,
      			},
      			tooltip: {
      				enabled: false
      			},
      			axisBorder: {
      				show: false,
      			},
      			type: 'category',
      		},
      		yaxis: {
      			labels: {
      				padding: 4
      			},
      		},
      		labels: [
                  @foreach($item->statistikPilihan as $statistik)
                      "{{$statistik->pilihan->title}}",
                  @endforeach
      		],
      		colors: [tabler.getColor("primary")],
      		legend: {
      			show: false,
      		},
      	})).render();
      });
      // @formatter:on
    </script>
@endforeach
@endpush
