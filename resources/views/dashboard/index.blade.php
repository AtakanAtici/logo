@extends('layouts.main')

@section('content')

<div class="row gy-3">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Cari - Sipariş</h4>
            </div>
            <div class="card-body">
                <div id="client_chart"></div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
         var options = {
          series: [{
          name: 'Inflation',
          data: [
             @foreach ($currentInfo as $current)
                 {{$current['price']}},
             @endforeach
          ]
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val + "₺";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: [
            @foreach ($currentInfo as $current)
                '{{$current['name']}}',
            @endforeach
          ],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "₺";
            }
          }
        
        },
        title: {
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#client_chart"), options);
        chart.render();
    </script>
@endsection