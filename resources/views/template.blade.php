<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $title }} | {{ env('APP_NAME') }}</title>
  <link rel="icon" href="{{ asset('img/logo_pemda.png') }}">
  <link rel="stylesheet" href="{{ asset('fonts/font1.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="blue-gradient">
  <header class="col-md-8 offset-md-2 d-flex py-3 px-2">
    <div class="d-flex col-2 logo-wrapper">
      <img class="d-flex logo" src="{{ asset('img/logo_pemda.png') }}" alt="Logo Pemda">
    </div>
    <div class="d-flex flex-column col-md-8 title pt-2">
      <h1>{{ strtoupper(env('APP_NAME')) }}</h1>
      <h2>{{ strtoupper(@$configs->lembaga)??'UPTD SMP NEGERI 39 SINJAI' }}</h2>
    </div>
    {{-- <div class="d-flex col-2 logo-wrapper">
      <img class="d-flex logo" src="{{ asset('img/logo_sekolah.png') }}" alt="Logo Sekolah">
    </div> --}}
  </header>

  <div id="wrapper">
    <div id="content">
      @yield('content')
    </div>
  </div>
  <footer class="container-fluid">
    <div class="row pb-3">
      <div class="col-md-3 order-md-0">
        @if ($ulinks->count())
        @foreach ($ulinks as $key => $l)
        @if (($key+1) % 2 != 0)
        <a href="{{ $l->link_val }}" class="box-footer d-block text-center" title="{{ $l->description }}">
          {{ $l->name }}
        </a>
        @endif
        @endforeach
        @endif
      </div>
      <div class="col-md-3 order-md-2">
        @if ($ulinks->count())
        @foreach ($ulinks as $key => $l)
        @if (($key+1) % 2 == 0)
        <a href="{{ $l->link_val }}" class="box-footer d-block text-center" title="{{ $l->description }}">
          {{ $l->name }}
        </a>
        @endif
        @endforeach
        @endif
      </div>
      <div class="col-md-6 order-md-1 text-center medsos-wrapper">
        <div class="box-medsos d-inline-block">
          <h4>Official Social Media</h4>
          <div class="row text-center">
            <div class="col-12 d-inline-block">
              @if (@$configs->website)
              <a class="icon" target="_blank" href="{{ @$configs->website }}">
                <img src="{{ asset('img/website.png') }}" alt="">
              </a>
              @endif
              @if (@$configs->account_youtube)
              <a class="icon" target="_blank" href="{{ @$configs->account_youtube }}">
                <img src="{{ asset('img/youtube.png') }}" alt="">
              </a>
              @endif
              @if (@$configs->account_instagram)
              <a class="icon" target="_blank" href="{{ @$configs->account_instagram }}">
                <img src="{{ asset('img/instagram.png') }}" alt="">
              </a>
              @endif
              @if (@$configs->account_facebook)
              <a class="icon" target="_blank" href="{{ @$configs->account_facebook }}">
                <img src="{{ asset('img/facebook.png') }}" alt="">
              </a>
              @endif
              @if (@$configs->account_twitter)
              <a class="icon" target="_blank" href="{{ @$configs->account_twitter }}">
                <img src="{{ asset('img/twitter.png') }}" alt="">
              </a>
              @endif
              @if (@$configs->account_tiktok)
              <a class="icon" target="_blank" href="{{ @$configs->account_tiktok }}">
                <img src="{{ asset('img/tiktok.png') }}" alt="">
              </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>