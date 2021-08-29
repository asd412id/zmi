@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body text-center">
        <h4>Hai, {{ $user->name }}!</h4>
        <p>Atur informasi akunmu di halaman ini.</p>
        <a href="{{ route('logout') }}" class="btn btn-block btn-danger mt-3">Keluar</a>
      </div>
    </div>
    <div class="card">
      <form method="POST" action="{{ route('account.update') }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="iname">Nama</label>
            <input type="text" name="name" class="form-control" id="iname" value="{{ old('name')??$user->name }}"
              placeholder="Masukkan nama lengkap" required>
          </div>
          <div class="form-group">
            <label for="iemail">Alamat Email</label>
            <input type="email" name="email" class="form-control" id="iemail" value="{{ old('email')??$user->email }}"
              placeholder="Masukkan alamat email" required>
          </div>
          <div class="form-group">
            <label for="ipassword">Password Sekarang</label>
            <input type="password" name="password" class="form-control" id="ipassword"
              placeholder="Masukkan password sekarang" required>
          </div>
          <div class="form-group">
            <label for="inpassword">Password Baru</label>
            <input type="password" name="newpassword" class="form-control" id="inpassword"
              placeholder="Masukkan password baru jika ingin mengubah password">
          </div>
          <div class="form-group">
            <label for="irepassword">Ulang Password Baru</label>
            <input type="password" name="newpassword_confirmation" class="form-control" id="irepassword"
              placeholder="Masukkan ulang password baru">
          </div>
          <button type="submit" class="btn btn-block btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <form method="POST" action="{{ route('configs.update') }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="ilembaga">Nama Lembaga</label>
            <input type="text" name="lembaga" class="form-control" id="ilembaga"
              value="{{ @old('lembaga')??@$configs->lembaga }}" placeholder="Masukkan nama Lembaga/Instansi/Sekolah">
          </div>
          <div class="form-group">
            <label for="iwebsite">Website</label>
            <input type="text" name="website" class="form-control" id="iwebsite"
              value="{{ @old('website')??@$configs->website }}" placeholder="Masukkan alamat Website">
          </div>
          <div class="form-group">
            <label for="iaccount_facebook">Facebook</label>
            <input type="text" name="account_facebook" class="form-control" id="iaccount_facebook"
              value="{{ @old('account_facebook')??@$configs->account_facebook }}"
              placeholder="Masukkan alamat akun Facebook">
          </div>
          <div class="form-group">
            <label for="iaccount_instagram">Instagram</label>
            <input type="text" name="account_instagram" class="form-control" id="iaccount_instagram"
              value="{{ @old('account_instagram')??@$configs->account_instagram }}"
              placeholder="Masukkan alamat akun Instagram">
          </div>
          <div class="form-group">
            <label for="iaccount_youtube">Youtube</label>
            <input type="text" name="account_youtube" class="form-control" id="iaccount_youtube"
              value="{{ @old('account_youtube')??@$configs->account_youtube }}"
              placeholder="Masukkan alamat akun Youtube">
          </div>
          <div class="form-group">
            <label for="iaccount_twitter">Twitter</label>
            <input type="text" name="account_twitter" class="form-control" id="iaccount_twitter"
              value="{{ @old('account_twitter')??@$configs->account_twitter }}"
              placeholder="Masukkan alamat akun Twitter">
          </div>
          <div class="form-group">
            <label for="iaccount_tiktok">Tiktok</label>
            <input type="text" name="account_tiktok" class="form-control" id="iaccount_tiktok"
              value="{{ @old('account_tiktok')??@$configs->account_tiktok }}" placeholder="Masukkan alamat akun Tiktok">
          </div>
          <button type="submit" class="btn btn-block btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footer')
@if ($errors->any())
<script>
  @foreach($errors->all() as $err)
    toastr.error('{{ $err }}');
  @endforeach
</script>
@endif
@if (session()->has('success'))
<script>
  toastr.success('{{ session()->get('success') }}');
</script>
@endif
@endsection