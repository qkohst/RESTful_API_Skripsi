@extends('admin.layouts.master')

@section('title')
<title>Admin | Developer</title>
@endsection

@section('content')
<section class="cta-section text-center py-4 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Data Developer</h1>
  </div>
</section>
<!--//page-header-->
<div class="container py-3">
  <div class="card">
    <div class="table-responsive">
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
              <div class="d-flex justify-content-start align-items-center">

                <a href="{{ route('developer.show', $dev->id) }}" class="btn badge badge-info mx-0 px-2 py-2 mr-1"><i class="nav-icon fas fa-eye"></i> Detail</a>
                <!-- Button enable or desable  -->
                @if($dev->status =='Aktif')
                <form action="/admin/developer/{{$dev->id}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="text" class="form-control d-none" id="status" name="status" value="Non Aktif">
                  <button type="submit" class="btn badge badge-secondary mx-0 px-2 py-2" onclick="return confirm('Menonaktifkan User juga akan menonaktifkan semua status project pada user tersebut. Desable Status User ?')"><i class="fas fa-toggle-off"></i> Desable</button>
                </form>
                @else
                <form action="/admin/developer/{{$dev->id}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="text" class="form-control d-none" id="status" name="status" value="Aktif">
                  <button type="submit" class="btn badge badge-primary mx-0 px-2 py-2" onclick="return confirm('Enable Status User ?')"><i class="fas fa-toggle-on"></i> Enable</button>
                </form>
                @endif
                <!-- // Button enable or desable -->
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!--//table-responsive-->
  </div>
</div>
@endsection