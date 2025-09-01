<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard &mdash; App Presensi</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/sporta.svg') }}" type="image/x-icon">

  <!-- General CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
</head>

<body style="background: #e2e8f0">
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- Navbar -->
      <!-- Navbar -->
<nav class="navbar navbar-expand-lg main-navbar">
  <div class="container-fluid">

    <!-- Sidebar toggle -->
    <ul class="navbar-nav me-auto">
      <li>
        <a href="#" id="sidebarToggle" class="nav-link nav-link-lg">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <!-- Navbar Right -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle nav-link-lg nav-link-user"
           data-bs-toggle="dropdown" aria-expanded="false">
          <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle me-1">
          <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a href="{{ route('logout') }}" style="cursor: pointer"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="dropdown-item has-icon text-danger">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>

      <!-- Sidebar -->
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">APP SPORTA</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SPORTA</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">MAIN MENU</li>
            <li class="{{ setActive('admin/dashboard') }}">
              <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
              </a>
            </li>

            @can('posts.index')
            <li class="{{ setActive('admin/post') }}">
              <a class="nav-link" href="#">
                <i class="fas fa-book-open"></i> <span>Berita</span>
              </a>
            </li>
            @endcan

            @can('tags.index')
            <li class="{{ setActive('admin/tag') }}">
              <a class="nav-link" href="#"><i class="fas fa-tags"></i> <span>Tags</span></a>
            </li>
            @endcan

            @can('categories.index')
            <li class="{{ setActive('admin/category') }}">
              <a class="nav-link" href="#"><i class="fas fa-folder"></i> <span>Kategori</span></a>
            </li>
            @endcan

            @can('events.index')
            <li class="{{ setActive('admin/event') }}">
              <a class="nav-link" href="#"><i class="fas fa-bell"></i> <span>Agenda</span></a>
            </li>
            @endcan

            @if(auth()->user()->can('photos.index') || auth()->user()->can('videos.index'))
            <li class="menu-header">GALERI</li>
            @endif

            @can('photos.index')
            <li class="{{ setActive('admin/photo') }}">
              <a class="nav-link" href="#"><i class="fas fa-image"></i> <span>Foto</span></a>
            </li>
            @endcan

            @can('videos.index')
            <li class="{{ setActive('admin/video') }}">
              <a class="nav-link" href="#"><i class="fas fa-video"></i> <span>Video</span></a>
            </li>
            @endcan

            @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
            <li class="menu-header">PENGATURAN</li>
            @endif

            @can('sliders.index')
            <li class="{{ setActive('admin/slider') }}">
              <a class="nav-link" href="#"><i class="fas fa-laptop"></i> <span>Sliders</span></a>
            </li>
            @endcan

            <li class="dropdown {{ setActive('admin/role'). setActive('admin/permission'). setActive('admin/user') }}">
              @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Users
                  Management</span></a>
              @endif

              <ul class="dropdown-menu">
                @can('roles.index')
                <li class="{{ setActive('admin/role') }}">
                  <a class="nav-link" href="{{ route('admin.role.index') }}">
                    <i class="fas fa-unlock"></i> Roles
                  </a>
                </li>
                @endcan

                @can('permissions.index')
                <li class="{{ setActive('admin/permission') }}">
                  <a class="nav-link" href="{{ route('admin.permission.index') }}">
                    <i class="fas fa-key"></i> Permissions
                  </a>
                </li>
                @endcan

                @can('users.index')
                <li class="{{ setActive('admin/user') }}">
                  <a class="nav-link" href="{{ route('admin.user.index') }}">
                    <i class="fas fa-users"></i> Users
                  </a>
                </li>
                @endcan
              </ul>
            </li>
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> TEST INDONESIA
          <div class="bullet"></div> All Rights Reserved.
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script>
    //active select2
    $(document).ready(function () {
      $('select').select2({
        theme: 'bootstrap-5',
        width: 'style',
      });
    });

    //flash message
    @if(session()->has('success'))
      swal({
        type: "success",
        icon: "success",
        title: "BERHASIL!",
        text: "{{ session('success') }}",
        timer: 1500,
        showConfirmButton: false,
        showCancelButton: false,
        buttons: false,
      });
    @elseif(session()->has('error'))
      swal({
        type: "error",
        icon: "error",
        title: "GAGAL!",
        text: "{{ session('error') }}",
        timer: 1500,
        showConfirmButton: false,
        showCancelButton: false,
        buttons: false,
      });
    @endif
  </script>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.querySelector(".main-sidebar");

    sidebarToggle.addEventListener("click", function (e) {
      e.preventDefault();
      sidebar.classList.toggle("active");
    });
  });
</script>

</body>
</html>
