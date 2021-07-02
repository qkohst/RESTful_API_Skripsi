@extends('admin.layouts.master')

@section('title')
<title>Admin | API Client</title>
@endsection

@section('content')
<section class="cta-section text-center py-4 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Detail API Client</h1>
  </div>
</section>
<!--//page-header-->
<div class="container py-3">
  <div class="docs-overview py-3">
    <div class="table-responsive my-3">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="theme-bg-light">Developer</th>
            <td>{{$data->user_developer->nama_depan}} {{$data->user_developer->nama_belakang}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Nama Project</th>
            <td>{{$data->nama_project}}</td>
          </tr>
          <tr>
            <th class="theme-bg-light">Jenis Platform</th>
            <td>{{$data->platform}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Deskripsi</th>
            <td>{{$data->deskripsi}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Status</th>
            <td>
              @if($data->status =='Aktif')
              <span class="badge badge-success">{{$data->status}}</span>
              @else
              <span class="badge badge-danger">{{$data->status}}</span>
              @endif
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Created At</th>
            <td>{{$data->created_at}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--//table-responsive-->
    <div class="row justify-content-center">
      <div class="col-12 col-lg-12 py-3">
        <div class="card shadow-sm">
          <div class="card-body" id="traffic_request">
            <a class="card-link-mask" href="#"></a>
          </div>
          <!--//card-body-->
        </div>
        <!--//card-->
      </div>
      <!--//col-->
    </div>
    <!--//row-->
    </dev>
  </div>
  @endsection

  @section('highchars')
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script>
    // Traffic Request 
    Highcharts.chart('traffic_request', {
      chart: {
        type: 'column'
      },
      title: {
        text: 'Traffic Request'
      },
      subtitle: {
        text: 'Dalam Minggu Ini'
      },
      xAxis: {
        categories: <?php echo json_encode($date_traffic); ?>,
        crosshair: true
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Request'
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:.0f} request</b></td></tr>',
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
      series: [{
        name: 'Request Success',
        data: <?php echo json_encode($count_traffic_success); ?>,

      }, {
        name: 'Request Error',
        data: <?php echo json_encode($count_traffic_errors); ?>,
      }]
    });
  </script>
  @endsection