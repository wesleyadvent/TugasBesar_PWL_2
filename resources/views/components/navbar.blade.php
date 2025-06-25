<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-3">

    <!-- Info halaman aktif di kiri atas -->
    <div class="d-flex align-items-center me-auto">
      <b class="text-dark">
        You are at => 
        <strong>
          {{ ucfirst(request()->segment(1) ?? 'Home') }}
          @if(request()->segment(2))
            / {{ ucfirst(request()->segment(2)) }}
          @endif
        </strong>
      </b>
    </div>

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
      <ul class="navbar-nav d-flex align-items-center justify-content-end">

        <li class="nav-item mx-2 d-flex align-items-center">
          <b><span class="text-dark">Hi, {{ auth()->user()->name }}</span></b>
        </li>

        <li class="nav-item dropdown d-flex align-items-center">
          <a href="#" class="nav-link text-body px-2 d-flex align-items-center" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar avatar-sm rounded-circle shadow-sm border border-2 border-white overflow-hidden">
              <img src="{{ asset('assets/img/user-profile.jpeg') }}" alt="profile" class="w-100 h-100 object-fit-cover">
            </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end px-2 py-3 shadow-lg border-radius-xl mt-2"
            aria-labelledby="userDropdown" style="min-width: 200px;">
            <li class="mb-2">
              <a class="dropdown-item border-radius-md d-flex align-items-center" href="{{ route('profile.edit') }}">
                <i class="material-symbols-rounded me-2 text-primary">settings</i>
                <span>Settings</span>
              </a>
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                  onclick="event.preventDefault(); this.closest('form').submit();"
                  class="dropdown-item border-radius-md d-flex align-items-center text-danger">
                  <i class="material-symbols-rounded me-2 text-danger">logout</i>
                  <span>Logout</span>
                </a>
              </form>
            </li>
          </ul>
        </li>

        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>
