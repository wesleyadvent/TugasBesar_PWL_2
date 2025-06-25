<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-gradient-dark my-2"
  id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="#">
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img" width="26" height="26"
        alt="main_logo">
      <span class="ms-1 text-sm text-white">wesleyadvent</span>
    </a>
  </div>

  <hr class="horizontal dark mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      {{-- MENU ADMINISTRATOR --}}
      @if(Auth::user()->role == 'administrator')
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('administrator.dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('administrator.users.index') }}">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
      @endif

      {{-- MENU PANITIA --}}
      @if(Auth::user()->role == 'panitia')
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('panitia.dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('panitia.event.index') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Event</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('panitia.daftar_ulang.index') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Re-Registration</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('panitia.sertifikat.index') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Certificate</span>
          </a>
        </li>
        
        {{-- Tambahkan menu panitia lainnya di sini --}}
      @endif

      {{-- MENU MEMBER --}}
      @if(Auth::user()->role == 'member')
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('member.dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('member.eventSaya') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Event Saya</span>
          </a>
        </li>
        {{-- Tambahkan menu member lainnya di sini --}}
      @endif

      {{-- MENU KEUANGAN --}}
      @if(Auth::user()->role == 'keuangan')
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('keuangan.dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('keuangan.selesai') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">History</span>
          </a>
        </li>
        {{-- Tambahkan menu keuangan lainnya di sini --}}
      @endif

      {{-- MENU UMUM --}}
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-5">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('profile.edit') }}">
          <i class="material-symbols-rounded opacity-5">person</i>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>

      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-link text-white bg-transparent border-0 d-flex align-items-center">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Logout</span>
          </button>
        </form>
      </li>

    </ul>
  </div>
</aside>
