@extends('admin.layouts.master')

@section('title')
<title>Admin | Dashboard</title>
@endsection

@section('content')
<section class="cta-section text-center py-5 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white mb-3">RESTful API E-Skripsi</h1>
    <h3 class="mb-2 text-white">Selamat Datang {{Auth::guard('developer')->user()->nama_depan }}</h3>
    <div class="text-white single-col-max mx-auto">Anda Login Sebagai Admin</div>
  </div>
</section>
<!--//page-header-->
<div class="container">
  <div class="docs-overview py-5">
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
      name: 'Web Client',
      data: <?php echo json_encode($count_traffic_web); ?>,

    }, {
      name: 'Mobile Client',
      data: <?php echo json_encode($count_traffic_mobile); ?>,
    }]
  });
</script>
@endsection