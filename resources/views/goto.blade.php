@extends('template')
@section('content')
<div class="container-fluid link-wrapper">
  @if ($link)
  <div class="cat">{{ $link->name }}</div>
  <div class="container-fluid">
    <h4 class="p-2 text-center">{{ $link->description }}</h4>
    @if ($link->active_val)
    <h3 class="pt-3 pb-3 text-center">Halaman akan terbuka dalam 3 detik ...<br> atau klik tombol di bawah jika Anda
      tidak
      diarahkan ke halaman tujuan!</h2>
      <div class="row">
        <div class="link show">
          <a class="d-block" id="link-dest" title="Buka Link" target="_blank" href="{{ $link->destination }}">Buka
            Halaman</a>
          <a class="d-block mt-2" title="Homepage" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
        </div>
      </div>
      @else
      <h3 class="pt-3 pb-3 text-center">Ops, halaman saat ini tidak tersedia!</h2>
        <div class="row">
          <div class="link show">
            <a class="d-block" title="Homepage" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
          </div>
        </div>
        @endif
  </div>
  @else
  <div class="container-fluid">
    <h3 class="pt-3 pb-3 text-center">Ops, halaman yang Anda cari tidak ditemukan!</h2>
      <div class="row">
        <div class="link show">
          <a class="d-block" title="Homepage" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
        </div>
      </div>
  </div>
  @endif
</div>
@endsection