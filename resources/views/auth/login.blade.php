@extends('auth.layouts.master')
@section('title')
<title>Developer | Login</title>
@endsection

@section('form')
<div class="col-md-6 contents">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="mb-4">
        <h3><strong>Login</strong> Sebagai Developer</h3>
      </div>
      <form method="POST" action="/postlogin">
        {!! csrf_field() !!}
        <div class="form-group first">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>

        </div>
        <div class="form-group last mb-4">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>

        </div>

        <div class="d-flex mb-5 align-items-center">
          <label class="control control--checkbox mb-0"><span class="caption">Ingat saya</span>
            <input type="checkbox" checked="checked" />
            <div class="control__indicator"></div>
          </label>
          <span class="ml-auto"><a href="#" class="forgot-pass">Lupa Password ?</a></span>
        </div>

        <input type="submit" value="LOGIN" class="btn text-white btn-block btn-primary">

        <span class="d-block text-left my-4"> Belum punya akun ? <a href="/register" class="text-success" style="text-decoration:none">Daftar</a></span>
      </form>
    </div>
  </div>

</div>
@endsection