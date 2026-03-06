
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('#') }}" alt="profile" /> />
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          @auth
          <span class="font-weight-bold mb-2">
            {{ Auth::user()->name }}
          </span>
          <span class="text-secondary text-small">
            {{ Auth::user()->email }}
          </span>
          @endauth
        </div>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kategori.index') }}">
        <span class="menu-title">Kategori</span>
        <i class="mdi mdi-shape-plus menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('buku.index') }}">
        <span class="menu-title">Buku</span>
        <i class="mdi mdi-book-open menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('barang.index') }}">
        <span class="menu-title">Barang</span>
        <i class="mdi mdi-book-open menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('sertifikat.*','undangan.*') ? '' : 'collapsed' }}"
        data-bs-toggle="collapse"
        href="#generatePdf"
        aria-expanded="{{ request()->routeIs('sertifikat.*','undangan.*') ? 'true' : 'false' }}"
        aria-controls="generatePdf">

          <span class="menu-title">Generate PDF</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-file-pdf-box menu-icon"></i>
      </a>

      <div class="collapse {{ request()->routeIs('sertifikat.*','undangan.*') ? 'show' : '' }}"
          id="generatePdf">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('sertifikat.*') ? 'active' : '' }}"
                    href="{{ route('sertifikat.preview') }}">
                      Sertifikat
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('undangan.*') ? 'active' : '' }}"
                    href="{{ route('undangan.preview') }}">
                      Undangan
                  </a>
              </li>
          </ul>
      </div>
    </li>
  </ul>
</nav>
<!-- partial -->