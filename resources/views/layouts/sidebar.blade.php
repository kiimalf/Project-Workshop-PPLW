
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="#" alt="profile" />
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
    <li class="nav-item">
      <a class="nav-link" href="{{ route('kategori') }}">
        <span class="menu-title">Kategori</span>
        <i class="mdi mdi-shape-plus menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('buku') }}">
        <span class="menu-title">Buku</span>
        <i class="mdi mdi-book-open menu-icon"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- partial -->