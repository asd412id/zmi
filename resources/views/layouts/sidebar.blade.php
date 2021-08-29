<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{ route('homepage') }}" target="_blank" class="brand-link">
    <img src="{{ asset('img') }}/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Lihat Homepage</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('img') }}/avatar5.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('account') }}" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home')?'active':'' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Beranda</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category*')?'active':'' }}">
            <i class="nav-icon fas fa-tags"></i>
            <p>Kategori Link</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('link.index') }}" class="nav-link {{ request()->routeIs('link*')?'active':'' }}">
            <i class="nav-icon fas fa-link"></i>
            <p>Daftar Link</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>