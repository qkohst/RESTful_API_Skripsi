@extends('auth.layouts.master')
@section('title')
<title>Developer | Daftar</title>
@endsection

@section('form')
<div class="col-md-6 contents">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="mb-4">
        <h3><strong>Daftar</strong> Sebagai Developer</h3>
      </div>
      <form method="POST" action="/postregister">
        {!! csrf_field() !!}
        <div class="form-group first">
          <label for="nama_depan">Nama Depan</label>
          <input type="text" class="form-control" id="nama_depan" name="nama_depan" value="{{ old('nama_depan') }}" required>

        </div>

        <div class="form-group first">
          <label for="nama_belakang">Nama Belakang</label>
          <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" value="{{ old('nama_belakang') }}"  required>

        </div>
        <div class="form-group first">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>

        </div>
        <div class="form-group last mb-4">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>

        </div>
        <div class="form-group last mb-4">
          <label for="konfirmasi_password">Konfirmasi Password</label>
          <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" value="{{ old('konfirmasi_password') }}" required>

        </div>

        <div class="d-flex mb-5 align-items-center">
          <label class="control control--checkbox mb-0"><span class="caption">Ingat saya</span>
            <input type="checkbox" checked="checked" />
            <div class="control__indicator"></div>
          </label>
          <span class="ml-auto"><a href="#" class="forgot-pass">Lupa Password ?</a></span>
        </div>

        <input type="submit" value="DAFTAR" class="btn text-white btn-block btn-primary">

        <span class="d-block text-left my-4"> Sudah punya akun ? <a href="/login" class="text-success" style="text-decoration:none">Login</a></span>
      </form>
    </div>
  </div>

</div>
@endsection