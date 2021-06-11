@extends('users.layouts.master')

@section('title')
<title>User | Dashboard</title>
@endsection

@section('content')
<section class="cta-section text-center py-5 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white mb-3">RESTful API E-Skripsi</h1>
    <h3 class="mb-2 text-white">Selamat Datang {{Auth::guard('developer')->user()->nama_depan}}</h3>
    <div class="text-white single-col-max mx-auto">Anda Login Sebagai Developer</div>
    @if(Auth::guard('developer')->user()->status =='Aktif')
    <div class="pt-3 text-center">
      <a href="{{ route('myapp.create') }}" class="btn btn-light">Buat Project Baru<i class="fas fa-folder-plus ml-2"></i></a>
    </div>
    @else
    <div class="pt-3 text-center">
      <span class="badge badge-danger">User Anda Telah Dinonaktifkan Oleh Admin</span>
      <h6 class="mt-2 text-white">Silahkan Hubungi Admin Untuk Info Lebih Lanjut !</h6>
    </div>
    @endif
  </div>
</section>

<!-- // Modal Create Project  -->
<!--//page-header-->
<div class="container">
  <div class="docs-overview py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-4 py-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <span class="theme-icon-holder card-icon-holder mr-2">
                <i class="fas fa-map-signs"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Introduction</span>
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
                <i class="fas fa-arrow-down"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Installation</span>
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
                <i class="fas fa-box fa-fw"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">APIs</span>
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