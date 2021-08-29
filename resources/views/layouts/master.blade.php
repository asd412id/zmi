<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }} | {{ env('APP_NAME') }}</title>
  <link rel="icon" href="{{ asset('img/logo_pemda.png') }}">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  @yield('header')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{ $title }}</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </section>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }} <a href="https://www.facebook.com/aezdar">asd412id</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>
  <div class="modal fade" id="modal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  @yield('footer')
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>