@extends('users.layouts.master')

@section('title')
<title>User | Detail Project </title>
@endsection

@section('content')
<section class="cta-section text-center py-4 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Detail Project</h1>
  </div>
</section>
<!--//page-header-->
<div class="container">
  <div class="docs-overview py-3">
    <div class="d-flex justify-content-end align-items-center">
      <!-- Button enable or desable  -->
      @if(Auth::guard('developer')->user()->status =='Aktif')
      @if($data_api_client->status =='Aktif')
      <form action="/developer/myapp/{{$data_api_client->id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" class="form-control d-none" id="status" name="status" value="Non Aktif">
        <button type="submit" class="btn text-secondary" onclick="return confirm('Rubah Status API Key ?')"><i class="fas fa-toggle-off"></i> Desable API Key</button>
      </form>
      @else
      <form action="/developer/myapp/{{$data_api_client->id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" class="form-control d-none" id="status" name="status" value="Aktif">
        <button type="submit" class="btn text-primary" onclick="return confirm('Rubah Status API Key ?')"><i class="fas fa-toggle-on"></i> Enable API Key</button>
      </form>
      @endif
      @endif

      <!-- // Button enable or desable -->
    </div>

    <div class="table-responsive my-3">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="theme-bg-light">nama project</th>
            <td>{{$data_api_client->nama_project}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">platform</th>
            <td>{{$data_api_client->platform}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key</th>
            <td><code><b>{{$data_api_client->api_key}}</b></code></td>
          </tr>
          <tr>
            <th class="theme-bg-light">status api_key </th>
            @if($data_api_client->status =='Aktif')
            <td>
              <span class="badge badge-success">{{$data_api_client->status}}</span>
            </td>
            @else
            <td>
              <span class="badge badge-danger">{{$data_api_client->status}}</span>
            </td>
            @endif
          </tr>
          <tr>
            <th class="theme-bg-light">deskripsi</th>
            <td>{{$data_api_client->deskripsi}} </td>
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
  </div>
  <!--//container-->
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