@extends('admin.layouts.master')

@section('title')
<title>Admin | Developer</title>
@endsection

@section('content')
<section class="cta-section text-center py-5 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Data Developer</h1>
  </div>
</section>
<!--//page-header-->
<div class="container py-3">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive my-3">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Email</th>
              <th scope="col">Status</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 0; ?>
            @foreach($developer as $dev)
            <?php $no++; ?>
            <tr>
              <th scope="row">{{$no}}</th>
              <td>{{$dev->nama_depan}} {{$dev->nama_belakang}}</td>
              <td>{{$dev->email}}</td>
              <td>
                @if($dev->status =='Aktif')
                <span class="badge badge-success">{{$dev->status}}</span>
                @else
                <span class="badge badge-danger">{{$dev->status}}</span>
                @endif
              </td>
              <td>
                <a href="#" class="btn badge badge-info mx-0 px-2 py-2"><i class="nav-icon fas fa-eye"></i> Detail</a>
                <a href="#" class="btn badge badge-warning mx-0 px-2 py-2"><i class="nav-icon fas fa-pen"></i> Edit</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!--//table-responsive-->
    </div>
  </div>
</div>
@endsection