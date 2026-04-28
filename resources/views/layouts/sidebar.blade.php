
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav" id="sidebarParent">
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
          aria-expanded="{{ request()->routeIs('sertifikat.*','undangan.*') ? 'true' : 'false' }}">
        
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

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('modul_4.*') ? '' : 'collapsed' }}"
          data-bs-toggle="collapse"
          href="#modul_4"
          aria-expanded="{{ request()->routeIs('modul_4.*') ? 'true' : 'false' }}">
        
          <span class="menu-title">Tugas Modul 4</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-file-pdf-box menu-icon"></i>
      </a>

      <div class="collapse {{ request()->routeIs('modul_4.*') ? 'show' : '' }}"
          id="modul_4">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_4.tableHTML') ? 'active' : '' }}"
                      href="{{ route('modul_4.tableHTML') }}">
                      Tabel HTML
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_4.datatables') ? 'active' : '' }}"
                      href="{{ route('modul_4.datatables') }}">
                      Datatables
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_4.2select') ? 'active' : '' }}"
                      href="{{ route('modul_4.2select') }}">
                      Select Kota
                  </a>
              </li>
          </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('modul_5.*') ? '' : 'collapsed' }}"
          data-bs-toggle="collapse"
          href="#modul_5"
          aria-expanded="{{ request()->routeIs('modul_5.*') ? 'true' : 'false' }}">
        
          <span class="menu-title">Tugas Modul 5</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-file-pdf-box menu-icon"></i>
      </a>

      <div class="collapse {{ request()->routeIs('modul_5.*') ? 'show' : '' }}"
          id="modul_5">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_5.ajaxSelect') ? 'active' : '' }}"
                      href="{{ route('modul_5.ajaxSelect') }}">
                      Select dengan AJAX
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_5.axiosSelect') ? 'active' : '' }}"
                      href="{{ route('modul_5.axiosSelect') }}">
                      Select dengan Axios
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_5.ajaxPOS') ? 'active' : '' }}"
                      href="{{ route('modul_5.ajaxPOS') }}">
                      POS dengan AJAX
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('modul_5.axiosPOS') ? 'active' : '' }}"
                      href="{{ route('modul_5.axiosPOS') }}">
                      POS dengan Axios
                  </a>
              </li>
          </ul>
      </div>
    </li>
    
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('customer.*') ? '' : 'collapsed' }}"
          data-bs-toggle="collapse"
          href="#customerMenu"
          aria-expanded="{{ request()->routeIs('customer.*') ? 'true' : 'false' }}">

          <span class="menu-title">Customer</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-account-group menu-icon"></i>
      </a>

      <div class="collapse {{ request()->routeIs('customer.*') ? 'show' : '' }}"
          id="customerMenu">

          <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('customer.index') ? 'active' : '' }}"
                      href="{{ route('customer.index') }}">
                      Catalog Menu
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('customer.pesanan') ? 'active' : '' }}"
                      href="{{ route('customer.pesanan') }}">
                      Daftar Pesanan
                  </a>
              </li>
          </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('vendor.*') ? '' : 'collapsed' }}"
          data-bs-toggle="collapse"
          href="#vendor"
          aria-expanded="{{ request()->routeIs('vendor.*') ? 'true' : 'false' }}">

          <span class="menu-title">Vendor</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-store menu-icon"></i>
      </a>

      <div class="collapse {{ request()->routeIs('vendor.*') ? 'show' : '' }}"
          id="vendor">

          <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('vendor.menu.*') ? 'active' : '' }}"
                      href="{{ route('vendor.menu.index', '1') }}">
                      Daftar Menu
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('vendor.pesanan.*') ? 'active' : '' }}"
                      href="{{ route('vendor.pesanan.index', '1') }}">
                      Daftar Pesanan
                  </a>
              </li>
          </ul>
      </div>
    </li>
  </ul>
</nav>
<!-- partial -->