@extends('admin.layouts.master')

@section('title')
<title>Admin | Developer</title>
@endsection

@section('content')
<section class="cta-section text-center py-4 theme-bg-dark position-relative">
  <div class="theme-bg-shapes-right"></div>
  <div class="theme-bg-shapes-left"></div>
  <div class="container">
    <h1 class="text-white">Detail Developer</h1>
  </div>
</section>
<!--//page-header-->
<div class="container py-3">
  <div class="docs-overview py-3">
    <div class="table-responsive my-3">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="theme-bg-light">Nama</th>
            <td>{{$data->nama_depan}} {{$data->nama_belakang}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Email</th>
            <td>{{$data->email}} </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Status Pengguna</th>
            <td>
              @if($data->status =='Aktif')
              <span class="badge badge-success">{{$data->status}}</span>
              @else
              <span class="badge badge-danger">{{$data->status}}</span>
              @endif
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Jumlah Project</th>
            <td>{{$count_api}} Aplikasi</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--//table-responsive-->
    <div class="row justify-content-center">
      @foreach($api_client as $client)
      <div class="col-12 col-lg-4 py-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-1">
              <span class="theme-icon-holder card-icon-holder mr-2">
                @if($client->platform =='Mobile')
                <i class="fas fa-mobile-alt"></i>
                @else
                <i class="fas fa-desktop"></i>
                @endif
              </span>
              <!--//card-icon-holder-->
              <span class="card-title-text">{{$client->nama_project}}</span>
            </h5>
            <div class="card-text">
              <small>Created At : {{$client->created_at}}</small>
            </div>
            <div class="card-text">
              <small>Status Project :
                @if($client->status =='Aktif')
                <span class="badge badge-success">{{$client->status}}</span>
                @else
                <span class="badge badge-danger">{{$client->status}}</span>
                @endif
              </small>
            </div>

            <div class="card-text">
              <span>{{$client->deskripsi}}</span>
            </div>
            <a class="card-link-mask" href="{{ route('apiclient.show', $client->id) }}"></a>
          </div>
          <!--//card-body-->
        </div>
        <!--//card-->
      </div>
      @endforeach
      <!--//col-->
    </div>
    <!--//row-->
    </dev>
  </div>
  @endsection