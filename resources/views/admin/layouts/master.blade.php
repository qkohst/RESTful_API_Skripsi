<!DOCTYPE html>
<html lang="en">

<head>
  @yield('title')
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
  <script defer src="/assets/fontawesome/js/all.min.js"></script>

  <!-- Theme CSS -->
  <link id="theme-style" rel="stylesheet" href="/assets/css/theme.css">

  <!-- MyStyle CSS -->
  <link id="theme-style" rel="stylesheet" href="/assets/css/mystyle.css">

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
          <div class="site-logo"><a class="navbar-brand" href="/dashboard"><img class="logo-icon mr-2" src="/assets/images/logo.png" width="30" height="30" alt="logo"><span class="logo-text">RESTfulAPI<span class="text-alt">Admin</span></span></a></div>
          <small>Versi : 1.0</small>
        </div>
        <!--//docs-logo-wrapper-->
        <div class="docs-top-utilities d-flex justify-content-end align-items-center">
          <a href="/dashboard" class="btn text-primary d-none d-lg-flex mx-1">Dashboard</a>
          <a href="{{ route('developer.index') }}" class="btn text-primary d-none d-lg-flex mx-1">Developer</a>
          <a href="{{ route('apiclient.index') }}" class="btn text-primary d-none d-lg-flex mx-1">API Client</a>
          <a href="{{ route('logout') }}" class="btn btn-primary d-none d-lg-flex mx-1" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
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
        <a href="/dashboard" class="btn text-perimary mx-1">Dashboard</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('developer.index') }}" class="btn text-perimary mx-1">Developer</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('apiclient.index') }}" class="btn text-perimary mx-1">API Client</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logout') }}" class="btn btn-primary d-none d-lg-flex mx-1" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </div>
  <!--//docs-sidebar-->

  <div class="page-content">
    @yield('content')
  </div>
  <!--//page-content-->

  @include('footer')
  @include('sweetalert::alert')
  <button onclick="topFunction()" id="myBtn" title="Back To Top"><i class="fas fa-chevron-up"></i></button>

  <!-- Javascript -->
  <script src="/assets/plugins/jquery-3.4.1.min.js"></script>
  <script src="/assets/plugins/popper.min.js"></script>
  <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

  <script src="/assets/js/docs.js"></script>

  <script src="/assets/js/mycode.js"></script>

  @yield('highchars')
  
</body>

</html>