@extends('users.layouts.master')

@section('title')
<title>User | Create Project</title>
@endsection

@section('content')
<section class="cta-section text-center py-4 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Buat Project Baru</h1>
  </div>
</section>
<!--//page-header-->
<div class="container py-3">
  <div class="card">
    <div class="card-body">
      <form action="{{ route('myapp.store') }}" method="POST">
        {{csrf_field()}}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nama_project">Nama Project</label>
              <input type="text" class="form-control" id="nama_project" name="nama_project" value="{{ old('nama_project') }}" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="jenis_platform">Jenis Platform</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_platform" id="web" value="Web" {{ old('jenis_platform') == "Web" ? 'checked' : '' }}>
                <label class="form-check-label" for="web">
                  Web
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_platform" id="mobile" value="Mobile" {{ old('jenis_platform') == "Mobile" ? 'checked' : '' }}>
                <label class="form-check-label" for="mobile">
                  Mobile
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="deskripsi">Deskripsi Project</label>
          <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{old('deskripsi')}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/dashboard" class="btn btn-light text-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection