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
                <i class="fas fa-file-alt"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Pengantar</span>
            </h5>
            <div class="card-text">
              Ini merupakan Dokumentasi RESTful API (Application Programming Interface) E-Skripsi Universitas PGRI Ronggolawe Tuban yang dapat ... <a href="#">baca selengkapnya</a> </div>
            <a class="card-link-mask" href="/docs#section-2" target="_black"></a>
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
                <i class="fas fa-star-half-alt"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Memulai</span>
            </h5>
            <div class="card-text">
              Untuk mulai anda memerlukan API Key. Silahkan <a href="/register">daftar</a> untuk mendapatkan API Key anda. <br>
              Anda harus tahu cara ... <a href="#">baca selengkapnya</a>
            </div>
            <a class="card-link-mask" href="/docs#section-1"></a>
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
                <i class="fab fa-readme"></i>
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">Dokumentasi</span>
            </h5>
            <div class="card-text">
              Server :
              http://127.0.0.1:8000/api/v1

              Berikut adalah struktur response yang akan anda dapatkan saat melakukan request ... <a href="#">baca selengkapnya</a> </div>
            <a class="card-link-mask" href="/docs#section-3"></a>
          </div>
          <!--//card-body-->
        </div>
        <!--//card-->
      </div>
      <!--//col-->
    </div>
    <!--//row-->
    <!--//row-->
  </div>
  <!--//container-->
</div>
@endsection