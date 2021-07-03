<!DOCTYPE html>
<html lang="en">

<head>
  <title>RESTful API Skripsi | Unirow Tuban</title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="description" content="Bootstrap 4 Template For Software Startups">
  <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
  <link rel="shortcut icon" href="favicon.ico">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

  <!-- FontAwesome JS-->
  <script defer src="assets/fontawesome/js/all.min.js"></script>

  <!-- Plugins CSS -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.2/styles/atom-one-dark.min.css">

  <!-- Theme CSS -->
  <link id="theme-style" rel="stylesheet" href="assets/css/theme.css">

  <!-- MyStyle CSS -->
  <link id="theme-style" rel="stylesheet" href="assets/css/mystyle.css">

</head>

<body class="docs-page">
  <header class="header fixed-top">
    <div class="branding docs-branding">
      <div class="container-fluid position-relative py-2">
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
          <a href="/" class="btn text-primary d-none d-lg-flex mx-1">Dashboard</a>
          <a target="_black" href="/login" class="btn btn-light d-none d-lg-flex mx-1">Login</a>
        </div>
        <!--//docs-top-utilities-->
      </div>
      <!--//container-->
    </div>
    <!--//branding-->
  </header>
  <!--//header-->

  <div class="docs-wrapper">
    <div id="docs-sidebar" class="docs-sidebar">
      <nav id="docs-nav" class="docs-nav navbar">
        <ul class="section-items list-unstyled nav flex-column pb-3">
          <li class="nav-item section-title mt-0">
            <a class="nav-link scrollto" href="#section-2"><span class="theme-icon-holder mr-2"><i class="fas fa-file-alt"></i></span>Pengantar</a>
          </li>
          <li class="nav-item section-title">
            <a class="nav-link scrollto active" href="#section-1"><span class="theme-icon-holder mr-2"><i class="fas fa-star-half-alt"></i></span>Memulai</a>
          </li>
          <li class="nav-item section-title mt-0 mb-0"><a class="nav-link scrollto" href="#section-3"><span class="theme-icon-holder mr-2"><i class="fab fa-readme"></i></span>Dokumentasi</a></li>
          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-4">Auth</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-4-1">Login</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-4-2">Ganti Password</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-4-3">Logout</a></li>
          </ul>

          <!-- Sidebar Admin  -->
          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-5">Admin/Profile</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-5-1">Lihat Profile</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-5-2">Update Profile</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-6">Admin/Fakultas</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-6-1">Lihat Data Fakultas</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-6-2">Tambah Fakultas</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-6-3">Fakultas By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-6-4">Update Fakultas</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-6-5">Hapus Fakultas</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-6-6">Fakultas Aktif</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-7">Admin/Program Studi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-7-1">Lihat Data Program Studi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-7-2">Tambah Program Studi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-7-3">Program Studi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-7-4">Update Program Studi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-7-5">Hapus Program Studi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-7-6">Program Studi Aktif By ID Fakultas</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-8">Admin/Jabatan Struktural</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-8-1">Lihat Data Jabatan Struktural</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-8-2">Tambah Jabatan Struktural</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-8-3">Jabatan Struktural By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-8-4">Update Jabatan Struktural</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-8-5">Hapus Jabatan Struktural</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-9">Admin/Jabatan Fungsional</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-9-1">Lihat Data Jabatan Fungsional</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-9-2">Tambah Jabatan Fungsional</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-9-3">Jabatan Fungsional By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-9-4">Update Jabatan Fungsional</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-9-5">Hapus Jabatan Fungsional</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-10">Admin/Admin Prodi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-10-1">Lihat Data Admin Prodi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-10-2">Tambah Admin Prodi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-10-3">Admin Prodi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-10-4">Update Admin Prodi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-10-5">Hapus Admin Prodi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-10-6">Reset Password Admin Prodi</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-11">Admin/Seminar Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-11-1">Lihat Data Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-11-2">Seminar Proposal By ID</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-12">Admin/Sidang Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-12-1">Lihat Data Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-12-2">Sidang Skripsi By ID</a></li>
          </ul>
        </ul>
      </nav>
      <!--//docs-nav-->
    </div>
    <!--//docs-sidebar-->
    <div class="docs-content">
      <div class="container">
        @include('docs.pengantar')
        @include('docs.mulai')
        @include('docs.docsindex')
        @include('docs.auth')

        <!-- Conten Admin  -->
        @include('docs.admin.profile')
        @include('docs.admin.fakultas')
        @include('docs.admin.prodi')
        @include('docs.admin.jabatanstruktural')
        @include('docs.admin.jabatanfungsional')
        @include('docs.admin.adminprodi')
        @include('docs.admin.seminarproposal')
        @include('docs.admin.sidangskripsi')
      </div>
      @include('footer')
      <button onclick="topFunction()" id="myBtn" title="Back To Top"><i class="fas fa-chevron-up"></i></button>
    </div>
  </div>
  <!--//docs-wrapper-->



  <!-- Javascript -->
  <script src="assets/plugins/jquery-3.4.1.min.js"></script>
  <script src="assets/plugins/popper.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>


  <!-- Page Specific JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>
  <script src="assets/js/highlight-custom.js"></script>
  <script src="assets/plugins/jquery.scrollTo.min.js"></script>
  <script src="assets/plugins/lightbox/dist/ekko-lightbox.min.js"></script>
  <script src="assets/js/docs.js"></script>

  <script src="assets/js/mycode.js"></script>
</body>

</html>