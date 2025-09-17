<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard &mdash; App Sporta</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/sporta.svg') }}" type="image/x-icon">


  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <!-- Select2 Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

  <!-- Custom Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <!-- jQuery (masih dipakai untuk select2 & sweetalert) -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
</head>

<body style="background: #e2e8f0">
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>


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
           
          <!-- Foto Profil -->
<img alt="Profile"
     src="{{ auth()->user()->profile_url }}"
     class="rounded-circle me-1"
     style="width: 35px; height: 35px; object-fit: cover;">

<div class="d-sm-none d-lg-inline-block">
  Hi, {{ auth()->user()->name }}
</div>

        </a>

        <!-- Dropdown -->
        <ul class="dropdown-menu dropdown-menu-end shadow">
          <li>
            <a href="{{ route('profile.edit') }}" class="dropdown-item">
              <i class="fas fa-user-edit me-2"></i> Edit Profile
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a href="{{ route('logout') }}" style="cursor: pointer"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="dropdown-item text-danger">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </li>
        </ul>

        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
      <a href="{{ route('admin.dashboard.index') }}">APP SPORTA</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('admin.dashboard.index') }}">SPORTA</a>
    </div>

    <ul class="sidebar-menu"> 
      <li class="menu-header">MAIN MENU</li>
       <li class="{{ setActive('admin/dashboard') }}"> 
        <a class="nav-link" href="{{ route('admin.dashboard.index') }}"> 
          <i class="fas fa-tachometer-alt"></i> 
          <span>Dashboard</span> 
        </a> 
      </li>

      @can('categories.index')
<li class="dropdown {{ setActive('admin/maincategories') }} {{ setActive('admin/subcategories') }}">
  <a href="#" class="nav-link has-dropdown">
    <i class="fas fa-folder"></i> <span>Kategori</span>
  </a>
  <ul class="dropdown-menu">
    <li class="{{ setActive('admin/maincategories') }}">
      <a class="nav-link" href="{{ route('admin.maincategories.index') }}">
        <i class="fas fa-folder-open"></i> Main Category
      </a>
    </li>
    <li class="{{ setActive('admin/subcategories') }}">
      <a class="nav-link" href="{{ route('admin.subcategories.index') }}">
        <i class="fas fa-folder-minus"></i> Sub Category
      </a>
    </li>
  </ul>
</li>
@endcan

     @if(auth()->user()->can('photos.index') || auth()->user()->can('videos.index'))
    <li class="menu-header">MEDIA</li>
@endif

@can('photos.index')
<li class="{{ setActive('admin.medias.index', 'image') }}">
  <a class="nav-link" href="{{ route('admin.medias.index', ['type' => 'image']) }}">
    <i class="fas fa-image"></i> <span>Foto</span>
  </a>
</li>
@endcan

@can('videos.index')
<li class="{{ setActive('admin.medias.index', 'video') }}">
  <a class="nav-link" href="{{ route('admin.medias.index', ['type' => 'video']) }}">
    <i class="fas fa-video"></i> <span>Video</span>
  </a>
</li>
@endcan


     {{-- ORGANISASI --}}
@if(auth()->user()->can('organizations.index') || auth()->user()->can('groups.index') || auth()->user()->can('affiliations.index'))
    <li class="menu-header">ORGANISASI</li>
@endif

@can('organizations.index')
<li class="{{ setActive('admin/organizations*') }}">
    <a class="nav-link" href="{{ route('admin.organizations.index') }}">
        <i class="fas fa-building"></i> <span>Organizations</span>
    </a>
</li>
@endcan

@can('groups.index')
<li class="{{ setActive('admin/groups*') }}">
    <a class="nav-link" href="{{ route('admin.groups.index') }}">
        <i class="fas fa-layer-group"></i> <span>Groups</span>
    </a>
</li>
@endcan


      {{-- AKTIVITAS --}}
      @if(auth()->user()->can('activities.index') || auth()->user()->can('attendances.index'))
        <li class="menu-header">AKTIVITAS</li>
      @endif

      @can('activities.index')
    <li class="{{ setActive('admin/activities*') }}">
        <a class="nav-link" href="{{ route('admin.activities.index') }}">
            <i class="fas fa-running"></i> <span>Activities</span>
        </a>
    </li>
@endcan

@can('attendances.index')
<li class="{{ setActive('admin/attendance-records*') }}">
    <a class="nav-link" href="{{ route('admin.attendance-records.index') }}">
        <i class="fas fa-check-circle"></i> <span>Attendance Records</span>
    </a>
</li>
@endcan


      {{-- EVENTS --}}
      @if(auth()->user()->can('events.index') || auth()->user()->can('schedules.index') || auth()->user()->can('registrations.index') || auth()->user()->can('payments.index'))
        <li class="menu-header">EVENTS</li>
      @endif

      @can('events.index')
      <li class="{{ setActive('admin/event') }}">
        <a class="nav-link" href="{{ route('admin.events.index') }}"><i class="fas fa-calendar"></i> <span>Events</span></a>
      </li>
      @endcan

      @can('schedules.index')
      <li class="{{ setActive('admin/schedule') }}">
        <a class="nav-link" href="{{ route('admin.schedules.index') }}"><i class="fas fa-clock"></i> <span>Event Schedules</span></a>
      </li>
      @endcan

      @can('registrations.index')
      <li class="{{ setActive('admin/registration') }}">
        <a class="nav-link" href="{{ route('admin.registrations.index') }}"><i class="fas fa-edit"></i> <span>Event Registrations</span></a>
      </li>
      @endcan

      @can('payments.index')
      <li class="{{ setActive('admin/payment') }}">
        <a class="nav-link" href="{{ route('admin.payments.index') }}"><i class="fas fa-credit-card"></i> <span>Payments</span></a>
      </li>
      @endcan

      {{-- PENGATURAN --}}
      @if(auth()->user()->can('roles.index') || auth()->user()->can('permissions.index') || auth()->user()->can('users.index'))
        <li class="menu-header">PENGATURAN</li>
      @endif

      {{-- Users Management --}}
      @if(auth()->user()->can('roles.index') || auth()->user()->can('permissions.index') || auth()->user()->can('users.index'))
      <li class="dropdown {{ setActive('admin/role'). setActive('admin/permission'). setActive('admin/user') }}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Users Management</span></a>
        <ul class="dropdown-menu">
          @can('roles.index')
          <li class="{{ setActive('admin/role') }}">
            <a class="nav-link" href="{{ route('admin.role.index') }}"><i class="fas fa-unlock"></i> Roles</a>
          </li>
          @endcan
          @can('permissions.index')
          <li class="{{ setActive('admin/permission') }}">
            <a class="nav-link" href="{{ route('admin.permission.index') }}"><i class="fas fa-key"></i> Permissions</a>
          </li>
          @endcan
          @can('users.index')
          <li class="{{ setActive('admin/user') }}">
            <a class="nav-link" href="{{ route('admin.user.index') }}"><i class="fas fa-users"></i> Users</a>
          </li>
          @endcan
        </ul>
      </li>
      @endif
    </ul>
  </aside>
</div>

      <!-- Main Content -->
      @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> APP SPORTA
          <div class="bullet"></div> All Rights Reserved.
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>

  <!-- Bootstrap 5 Bundle (JS + Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- Template JS -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script>
    // Active select2
    $(document).ready(function () {
      $('select').select2({
        theme: 'bootstrap-5',
        width: 'style',
      });
    });

    // Flash message
    @if(session()->has('success'))
      swal({
        icon: "success",
        title: "BERHASIL!",
        text: "{{ session('success') }}",
        timer: 1500,
        buttons: false,
      });
    @elseif(session()->has('error'))
      swal({
        icon: "error",
        title: "GAGAL!",
        text: "{{ session('error') }}",
        timer: 1500,
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
