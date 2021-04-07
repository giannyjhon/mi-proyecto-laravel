@extends('layouts.panel')

@section('content')


          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Reporte: Médicos más Activos</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="input-daterange datepicker row align-items-center"
              data-date-format="yyyy-mm-dd">
      <div class="col">
          <div class="form-group">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                  </div>
                  <input class="form-control"
                  placeholder="Fecha de Inicio"
                  id="startDay"
                  type="text" value="{{$start}}">
              </div>
          </div>
      </div>
      <div class="col">
          <div class="form-group">
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                  </div>
                  <input class="form-control"
                  placeholder="Fecha de Fin"
                  id="endDay"
                  type="text" value="{{$end}}">
              </div>
          </div>
      </div>
  </div>
              <div id="container"></div>
            </div>
          </div>
@endsection

@section('scripts')
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script src={{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}></script>
  <script >

  const chart = Highcharts.chart('container', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Médicos más Activos'
      },
      xAxis: {
          categories: [],
          crosshair: true
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Citas Atendidas'
          }
      },
      tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y} Citas</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          }
      },
      series: []

  });

  let $start, $end;

function fetchData(){
  $start = $('#startDay').val();
  $end = $('#endDay').val();
  const startDate = $start;
  const endDate = $end;

  const url =`/mi-proyecto-laravel/public/charts/doctors/column/data?start=${startDate}&end=${endDate}`

  fetch(url)
  .then(response => response.json())
  .then(data =>{
    console.log(data);
    chart.xAxis[0].setCategories(data.categories);
    if(chart.series.length > 0){
      chart.series[1].remove();
      chart.series[0].remove();
    }
    chart.addSeries(data.series[0]);//Atendidas
    chart.addSeries(data.series[1]);//cancelada
  });
}
$(function (){


//  console.log(start);
  fetchData();

  $('#startDay').change(fetchData);
  $('#endDay').change(fetchData);
})
  </script>
@endsection
