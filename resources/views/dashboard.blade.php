<!DOCTYPE html>
<html lang="en">

<head>
  <title>RESTful API Skripsi | Unirow Tuban</title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Bootstrap Documentation Template For Software Developers">
  <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
  <link rel="shortcut icon" href="favicon.ico">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

  <!-- FontAwesome JS-->
  <script defer src="assets/fontawesome/js/all.min.js"></script>

  <!-- Theme CSS -->
  <link id="theme-style" rel="stylesheet" href="assets/css/theme.css">

</head>

<body>
  <header class="header fixed-top">
    <div class="branding docs-branding">
      <div class="container position-relative py-2">
        <div class="docs-logo-wrapper">
          <button id="docs-sidebar-toggler" class="docs-sidebar-toggler docs-sidebar-visible mr-2 d-xl-none" type="button">
            <span></span>
            <span></span>
            <span></span>
          </button>
          <div class="site-logo"><a class="navbar-brand" href="/"><img class="logo-icon mr-2" src="assets/images/logo.png" width="30" height="30" alt="logo"><span class="logo-text">RESTfulAPI<span class="text-alt">Docs</span></span></a></div>
          <small>Versi : 1.0</small>
        </div>
        <!--//docs-logo-wrapper-->
        <div class="docs-top-utilities d-flex justify-content-end align-items-center">
          <a href="/docs#section-1" class="btn text-primary d-none d-lg-flex mx-1">Memulai</a>
          <a href="/docs#section-3" class="btn text-primary d-none d-lg-flex mx-1">Dokumentasi</a>
          <a target="_black" href="/login" class="btn btn-primary d-none d-lg-flex mx-1">Login</a>
        </div>
        <!--//docs-top-utilities-->
      </div>
      <!--//container-->
    </div>
    <!--//branding-->
  </header>
  <!--//header-->
  <div id="docs-sidebar" class="docs-sidebar d-lg-none">
    <ul class="section-items list-unstyled nav flex-column pb-3">
      <li class="nav-item">
        <a href="/docs#section-1" class="btn text-perimary mx-1">Memulai</a>
      </li>
      <li class="nav-item">
        <a href="/docs#section-3" class="btn text-perimary mx-1">Dokumentasi</a>
      </li>
      <li class="nav-item">
        <a target="_black" href="/login" class="btn text-perimary mx-1">Login</a>
      </li>
    </ul>
  </div>
  <!--//docs-sidebar-->

  <div class="page-content">
    <section class="cta-section text-center py-5 theme-bg-dark position-relative">
      <div class="theme-bg-shapes-right"></div>
      <div class="theme-bg-shapes-left"></div>
      <div class="container">
        <h1 class="mb-2 text-white mb-3">RESTful API E-Skripsi</h1>
        <div class="text-white mb-3 single-col-max mx-auto">Dokumentasi RESTful API Sistem Informasi Monitoring dan Evaluasi Tugas Akhir Mahasiswa Universitas PGRI Ronggolawe Tuban</div>
        <div class="pt-3 text-center">
          <a class="btn btn-light" target="_black" href="/login">Get
            API Key<i class="fas fa-arrow-alt-circle-right ml-2"></i></a>
        </div>
      </div>
    </section>
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
                <a class="card-link-mask" href="/docs#section-2"></a>
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
    <!--//container-->
  </div>
  <!--//page-content-->

  @include('footer')
  @include('sweetalert::alert')
  <!-- Javascript -->
  <script src="assets/plugins/jquery-3.4.1.min.js"></script>
  <script src="assets/plugins/popper.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/docs.js"></script>


</body>

</html>