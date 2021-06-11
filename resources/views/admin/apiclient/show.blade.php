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
      <div class="col-12 col-lg-4 py-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <span class="theme-icon-holder card-icon-holder mr-2">
                <i class="fas fa-chart-bar"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Traffic Request</span>
            </h5>
            <div class="card-text">
              Section overview goes here. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
            </div>
            <a class="card-link-mask" href="docs-page.html#section-1"></a>
          </div>
          <!--//card-body-->
        </div>
        <!--//card-->
      </div>
      <!--//col-->
      <div class="col-12 col-lg-4 py-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <span class="theme-icon-holder card-icon-holder mr-2">
                <i class="fas fa-check-circle"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Request Success</span>
            </h5>
            <div class="card-text">
              Section overview goes here. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
            </div>
            <a class="card-link-mask" href="docs-page.html#section-2"></a>
          </div>
          <!--//card-body-->
        </div>
        <!--//card-->
      </div>
      <!--//col-->
      <div class="col-12 col-lg-4 py-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <span class="theme-icon-holder card-icon-holder mr-2">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Request Errors</span>
            </h5>
            <div class="card-text">
              Section overview goes here. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.
            </div>
            <a class="card-link-mask" href="docs-page.html#section-3"></a>
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