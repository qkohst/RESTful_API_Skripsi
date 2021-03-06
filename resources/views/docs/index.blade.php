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
            <a class="nav-link scrollto active" href="#section-2"><span class="theme-icon-holder mr-2"><i class="fas fa-file-alt"></i></span>Pengantar</a>
          </li>
          <li class="nav-item section-title">
            <a class="nav-link scrollto" href="#section-1"><span class="theme-icon-holder mr-2"><i class="fas fa-star-half-alt"></i></span>Memulai</a>
          </li>
          <li class="nav-item section-title"><a class="nav-link scrollto" href="#section-3"><span class="theme-icon-holder mr-2"><i class="fab fa-readme"></i></span>Dokumentasi</a></li>
          <li class="nav-item section-title mb-0"><a class="nav-link scrollto" href="#section-4"><span class="theme-icon-holder mr-2"><i class="fa fa-sign-in-alt"></i></span>Auth</a></li>
          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-4">Auth</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-4-1">Login</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-4-2">Ganti Password</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-4-3">Logout</a></li>
          </ul>

          <!-- Sidebar Admin  -->
          <li class="nav-item section-title mb-0 mt-2"><a class="nav-link scrollto" href="#section-5"><span class="theme-icon-holder mr-2"><i class="fa fa-user-shield"></i></span>Admin</a></li>
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

          <!-- Sidebar Admin Prodi -->
          <li class="nav-item section-title mb-0 mt-2"><a class="nav-link scrollto" href="#section-13"><span class="theme-icon-holder mr-2"><i class="fa fa-user-tie"></i></span>Admin Prodi</a></li>
          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-13">Admin Prodi/Profile</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-13-1">Lihat Profile</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-13-2">Update Profile</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-14">Admin Prodi/Mahasiswa</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-14-1">Lihat Data Mahasiswa</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-14-2">Tambah Mahasiswa</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-14-3">Mahasiswa By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-14-4">Update Mahasiswa</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-14-5">Hapus Mahasiswa</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-14-6">Reset Password Mahasiswa</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-15">Admin Prodi/Dosen</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-1">Lihat Data Dosen</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-2">Tambah Dosen</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-3">Dosen By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-4">Update Dosen</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-5">Hapus Dosen</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-6">Reset Password Dosen</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-15-7">Dosen Aktif</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-16">Admin Prodi/Jabatan Dosen</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-16-1">Lihat Jabatan Struktural</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-16-2">Lihat Jabatan Fungsional</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-17">Admin Prodi/Persetujuan KRS</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-17-1">Lihat Data Persetujuan KRS</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-17-2">Persetujuan KRS By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-17-3">Verifikasi Persetujuan KRS</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-18">Admin Prodi/Seminar Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-1">Lihat Data Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-2">Seminar Proposal By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-3">Tentukan Penguji dan Waktu</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-4">Status Persetujuan Penguji</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-5">Hasil Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-6">Verifikasi Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-18-7">Nilai Seminar Proposal</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-19">Admin Prodi/Sidang Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-19-1">Lihat Data Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-19-2">Sidang Skripsi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-19-3">Tentukan Waktu Sidang</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-19-4">Hasil Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-19-5">Verifikasi Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-19-6">Nilai Sidang Skripsi</a></li>
          </ul>

          <!-- Sidebar Mahasiswa -->
          <li class="nav-item section-title mb-0 mt-2"><a class="nav-link scrollto" href="#section-20"><span class="theme-icon-holder mr-2"><i class="fa fa-user-graduate"></i></span>Mahasiswa</a></li>
          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-20">Mahasiswa/Profile</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-20-1">Lihat Profile</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-20-2">Update Profile</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-21">Mahasiswa/Dosen</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-21-1">Dosen By Status Aktif</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-21-2">Lihat Data Dosen Pembimbing</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-21-3">Lihat Data Dosen Penguji</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-22">Mahasiswa/Persyaratan Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-22-1">Upload KRS</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-22-2">Status Verifikasi Upload KRS</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-22-3">Pengajuan Judul Ke Pembimbing 1</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-22-4">Status Persetujuan Pembimbing 1</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-22-5">Pengajuan Judul Ke Pembimbing 2</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-22-6">Status Persetujuan Pembimbing 2</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-23">Mahasiswa/Bimbingan Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-23-1">Lihat Data Bimbingan Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-23-2">Pengajuan Bimbingan Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-23-3">Bimbingan Proposal By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-23-4">Berita Acara Bimbingan Proposal</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-24">Mahasiswa/Seminar Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-24-1">Pengajuan Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-24-2">Status Persetujuan Dosen Pembimbing</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-24-3">Dosen Penguji dan Waktu Seminar</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-24-4">Hasil Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-24-5">Hasil Seminar Proposal By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-24-6">Nilai Seminar Proposal</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-25">Mahasiswa/Bimbingan Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-25-1">Lihat Data Bimbingan Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-25-2">Pengajuan Bimbingan Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-25-3">Bimbingan Skripsi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-25-4">Berita Acara Bimbingan Skripsi</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-26">Mahasiswa/Sidang Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-26-1">Pengajuan Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-26-2">Status Persetujuan Dosen Pembimbing</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-26-3">Waktu Sidang</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-26-4">Hasil Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-26-5">Hasil Sidang Skripsi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-26-6">Rekap Nilai Sidang Skripsi</a></li>
          </ul>

          <!-- Sidebar Dosen -->
          <li class="nav-item section-title mb-0 mt-2"><a class="nav-link scrollto" href="#section-27"><span class="theme-icon-holder mr-2"><i class="fa fa-user-secret"></i></span>Dosen</a></li>
          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-27">Dosen/Profile</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-27-1">Lihat Profile</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-27-2">Update Profile</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-28">Dosen/Persetujuan Judul</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-28-1">Lihat Data Persetujuan Judul</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-28-2">Persetujuan Judul By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-28-3">Verifikasi Judul</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-29">Dosen/Persetujuan Dosen Penguji</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-29-1">Lihat Data Persetujuan Dosen Penguji</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-29-2">Persetujuan Dosen Penguji By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-29-3">Verifikasi Dosen Penguji</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-30">Dosen/Bimbingan Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-30-1">Lihat Data Bimbingan Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-30-2">Bimbingan Proposal By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-30-3">Verifikasi Bimbingan Proposal</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-31">Dosen/Persetujuan Seminar Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-31-1">Lihat Data Persetujuan Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-31-2">Persetujuan Seminar Proposal By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-31-3">Verifikasi Persetujuan Seminar Proposal</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-32">Dosen/Seminar Proposal</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-32-1">Lihat Data Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-32-2">Seminar Proposal By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-32-3">Verifikasi Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-32-4">Input Nilai Seminar Proposal</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-32-5">Lihat Nilai Seminar Proposal</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-33">Dosen/Bimbingan Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-33-1">Lihat Data Bimbingan Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-33-2">Bimbingan Skripsi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-33-3">Verifikasi Bimbingan Skripsi</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-34">Dosen/Persetujuan Sidang Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-34-1">Lihat Data Persetujuan Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-34-2">Persetujuan Sidang Skripsi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-34-3">Verifikasi Persetujuan Sidang Skripsi</a></li>
          </ul>

          <ul class="nav-item mx-0">
            <a class="nav-link scrollto" href="#section-35">Dosen/Sidang Skripsi</a>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-35-1">Lihat Data Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-35-2">Sidang Skripsi By ID</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-35-3">Verifikasi Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-35-4">Input Nilai Sidang Skripsi</a></li>
            <li class="nav-item"><a class="nav-link scrollto" href="#item-35-5">Lihat Nilai Sidang Skripsi</a></li>
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

        <!-- Conten Admin Prodi -->
        @include('docs.adminprodi.profile')
        @include('docs.adminprodi.mahasiswa')
        @include('docs.adminprodi.dosen')
        @include('docs.adminprodi.jabatandosen')
        @include('docs.adminprodi.persetujuankrs')
        @include('docs.adminprodi.seminarproposal')
        @include('docs.adminprodi.sidangskripsi')

        <!-- Conten Mahasiswa -->
        @include('docs.mahasiswa.profile')
        @include('docs.mahasiswa.dosen')
        @include('docs.mahasiswa.persyaratanskripsi')
        @include('docs.mahasiswa.bimbinganproposal')
        @include('docs.mahasiswa.seminarproposal')
        @include('docs.mahasiswa.bimbinganskripsi')
        @include('docs.mahasiswa.sidangskripsi')

        <!-- Conten Dosen -->
        @include('docs.dosen.profile')
        @include('docs.dosen.persetujuanjudul')
        @include('docs.dosen.persetujuandosenpenguji')
        @include('docs.dosen.bimbinganproposal')
        @include('docs.dosen.persetujuanseminarproposal')
        @include('docs.dosen.seminarproposal')
        @include('docs.dosen.bimbinganskripsi')
        @include('docs.dosen.persetujuansidangskripsi')
        @include('docs.dosen.sidangskripsi')

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