@extends('layouts.master')
@section('content')
<div class="row">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-12">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $cat }}</h3>
            <p>Kategori</p>
          </div>
          <div class="icon">
            <i class="fas fa-tags fa-fw"></i>
          </div>
          <a href="{{ route('category.index') }}" class="small-box-footer">Lihat <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $link }}</h3>
            <p>Link Halaman</p>
          </div>
          <div class="icon">
            <i class="fas fa-link fa-fw"></i>
          </div>
          <a href="{{ route('link.index') }}" class="small-box-footer">Lihat <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection