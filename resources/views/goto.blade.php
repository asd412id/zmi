@extends('template')
@section('content')
<div class="container-fluid link-wrapper">
  @if ($link)
  <div class="cat">{{ $link->name }}</div>
  <div class="container-fluid">
    <h4 class="p-2 text-center">{{ $link->description }}</h4>
    @if ($link->active_val)
    <h2 class="pt-5 pb-3 text-center">Klik tombol di bawah untuk membuka halaman!</h2>
    <div class="row">
      <div class="link">
        <a class="d-block" title="Buka Link" target="_blank" href="{{ $link->destination }}">Buka Halaman</a>
        <a class="d-block mt-2" title="Homepage" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
      </div>
    </div>
    @else
    <h2 class="pt-5 pb-3 text-center">Ops, halaman saat ini tidak tersedia!</h2>
    <div class="row">
      <div class="link">
        <a class="d-block" title="Homepage" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
      </div>
    </div>
    @endif
  </div>
  @else
  <div class="container-fluid">
    <h2 class="pt-5 pb-3 text-center">Ops, halaman yang Anda cari tidak ditemukan!</h2>
    <div class="row">
      <div class="link">
        <a class="d-block" title="Homepage" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection