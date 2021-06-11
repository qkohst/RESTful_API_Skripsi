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
  </div>
  <!--//container-->
</div>
@endsection