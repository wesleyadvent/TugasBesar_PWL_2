@extends('layouts.app2')

@section('content')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-2">

    <div class="row mb-4">
      <div class="d-flex flex-wrap align-items-center gap-3" style="max-width: 900px;">

      <!-- Tombol Tambah User Baru -->
      <a href="{{ route('administrator.users.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-1"></i> Tambah User Baru
      </a>

      <!-- Form Filter dan Search -->
      <form method="GET" action="{{ route('administrator.users.index') }}"
        class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">

        <!-- Dropdown filter role -->
        <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="roleDropdown"
          data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 150px;">
          {{ request('role') ? ucfirst(request('role')) : 'Pilih Role' }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="roleDropdown">
          <li>
          <a class="dropdown-item {{ request('role') == '' ? 'active' : '' }}"
            href="{{ route('administrator.users.index', array_merge(request()->except('role'), ['role' => ''])) }}">
            Semua Role
          </a>
          </li>
          
          <li>
          <a class="dropdown-item {{ request('role') == 'keuangan' ? 'active' : '' }}"
            href="{{ route('administrator.users.index', array_merge(request()->except('role'), ['role' => 'keuangan'])) }}">
            Keuangan
          </a>
          </li>
          <li>
          <a class="dropdown-item {{ request('role') == 'panitia' ? 'active' : '' }}"
            href="{{ route('administrator.users.index', array_merge(request()->except('role'), ['role' => 'panitia'])) }}">
            Panitia
          </a>
          </li>
        </ul>
        </div>

        <!-- Input Pencarian -->
        <div class=" input-group input-group-dynamic mb-4" style="max-width: 350px; max-height: 10;">
        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
          placeholder="Cari nama..." aria-label="Cari berdasarkan nama">


        </div>
        <button type="submit" class="btn btn-primary mb-3">
        <i class="fa fa-search me-1"></i> Cari
        </button>

        @if(request('search'))
      <a href="{{ route('administrator.users.index', request()->except('search')) }}"
      class="btn btn-outline-secondary" title="Hapus pencarian">
      <i class="bi bi-x-circle"></i>
      </a>
      @endif
      </form>
      </div>
    </div>


    <script>
      document.addEventListener('DOMContentLoaded', function () {
      const clearBtn = document.getElementById('clearSearchBtn');
      const searchInput = document.getElementById('searchInput');

      if (clearBtn) {
        clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.focus();

        searchInput.form.submit();
        });
      }
      });

      function focused(element) {
      element.parentNode.classList.add('focused');
      }

      function defocused(element) {
      if (!element.value) {
        element.parentNode.classList.remove('focused');
      }
      }
    </script>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <div class="row">
      <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Users Table</h6>
        </div>
        </div>

        <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0" style="overflow: visible;">
          <table class="table align-items-center justify-content-center mb-0">
          <thead>
            <tr>
            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-3">ID</th>
            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Nama</th>
            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Email</th>
            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Role</th>
            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Status</th>
            <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
          <tr>
          <td>
          <p class="text-sm font-weight-bold mb-0 ps-3">{{ $user->id }}</p>
          </td>
          <td>
          <p class="text-sm font-weight-bold mb-0">{{ $user->name }}</p>
          </td>
          <td>
          <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
          </td>
          <td><span class="text-xs font-weight-bold">{{ ucfirst($user->role) }}</span></td>
          <td>
          @if($user->status === 'aktif')
        <span class="badge bg-success">Aktif</span>
        @else
        <span class="badge bg-secondary">Nonaktif</span>
        @endif
          </td>
          <td class="text-end pe-3">
          <div class="dropdown text-end">
          <button class="btn btn-link text-secondary p-0" type="button"
            id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-ellipsis-v text-xs"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end px-2 py-3"
            aria-labelledby="dropdownMenuButton{{ $user->id }}">
            <li>
            <a class="dropdown-item border-radius-md"
            href="{{ route('administrator.users.edit', $user->id) }}">
            <i class="fa fa-edit me-2"></i>Edit
            </a>
            </li>
            <li>
            <form action="{{ route('administrator.users.destroy', $user->id) }}" method="POST"
            onsubmit="return confirm('Hapus user ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item border-radius-md text-danger">
            <i class="fa fa-trash me-2"></i>Hapus
            </button>
            </form>
            </li>
            <li>
            <form action="{{ route('administrator.users.toggleStatus', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="dropdown-item border-radius-md text-primary">
            <i
              class="fa {{ $user->status === 'aktif' ? 'fa-toggle-on' : 'fa-toggle-off' }} me-2"></i>
            {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
            </form>
            </li>
          </ul>
          </div>
          </td>
          </tr>
        @empty
        <tr>
        <td colspan="7" class="text-center text-muted py-5">
          <i class="fa fa-user-times fa-2x d-block mb-2"></i>
          Tidak ada user.
        </td>
        </tr>
        @endforelse
          </tbody>
          </table>
        </div>
        </div>

        <div class="mt-3 px-3">
        {{ $users->links() }}
        </div>

      </div>
      </div>
    </div>

    </div>
  </main>
@endsection