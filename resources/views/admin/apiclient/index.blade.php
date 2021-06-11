@extends('admin.layouts.master')

@section('title')
<title>Admin | API Client</title>
@endsection

@section('content')
<section class="cta-section text-center py-4 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Data API Client</h1>
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
            <th scope="col">Developer</th>
            <th scope="col">Nama Project</th>
            <th scope="col">Jenis Platform</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 0; ?>
          @foreach($api_client as $client)
          <?php $no++; ?>
          <tr>
            <th scope="row">{{$no}}</th>
            <td>{{$client->user_developer->nama_depan}} {{$client->user_developer->nama_belakang}}</td>
            <td>{{$client->nama_project}}</td>
            <td>{{$client->platform}}</td>
            <td>
              @if($client->status =='Aktif')
              <span class="badge badge-success">{{$client->status}}</span>
              @else
              <span class="badge badge-danger">{{$client->status}}</span>
              @endif
            </td>
            <td>
              <div class="d-flex justify-content-start align-items-center">
                <a href="{{ route('apiclient.show', $client->id) }}" class="btn badge badge-info mx-0 px-2 py-2 mr-1"><i class="nav-icon fas fa-eye"></i> Detail</a>
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