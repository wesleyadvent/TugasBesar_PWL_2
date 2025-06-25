@extends('layouts.app2')

@section('title', 'Dashboard Keuangan - Daftar Pendaftaran Event')

@section('content')
<div class="container-fluid py-2">
  <div class="row mb-4">
    <div class="d-flex flex-wrap align-items-center gap-3" style="max-width: 900px;">
      <form method="GET" action="{{ route('keuangan.dashboard') }}" class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">
        <!-- Input Pencarian -->
        <div class="input-group input-group-dynamic mb-4" style="max-width: 350px;">
          <input type="text" name="search" class="form-control" value="{{ request('search') }}"
            placeholder="Cari nama..." aria-label="Cari berdasarkan nama">
        </div>
        <button type="submit" class="btn btn-primary mb-3">
          <i class="fa fa-search me-1"></i> Cari
        </button>

        @if(request('search'))
        <a href="{{ route('keuangan.dashboard', request()->except('search')) }}" class="btn btn-outline-secondary"
          title="Hapus pencarian">
          <i class="bi bi-x-circle"></i>
        </a>
        @endif
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Daftar Peserta yang Mendaftar</h6>
          </div>
        </div>

        <div class="card-body px-0 pb-2">
          @if(session('success'))
          <div class="alert alert-success mx-3">{{ session('success') }}</div>
          @elseif(session('info'))
          <div class="alert alert-info mx-3">{{ session('info') }}</div>
          @endif

          @if($pendaftaran->isEmpty())
          <p class="text-center text-muted py-5">
            <i class="fa fa-calendar-times fa-2x d-block mb-2"></i>
            Tidak ada data pendaftaran.
          </p>
          @else
          <div class="table-responsive p-0" style="overflow: visible;">
            <table class="table align-items-center justify-content-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-3">ID Pendaftaran</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Nama User</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Email</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Nama Event</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Status Pembayaran</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Bukti Bayar</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pendaftaran as $data)
                <tr>
                  <td><p class="text-sm font-weight-bold mb-0 ps-3">{{ $data->id }}</p></td>
                  <td><p class="text-sm font-weight-bold mb-0">{{ $data->user->name ?? '-' }}</p></td>
                  <td><p class="text-sm text-muted mb-0">{{ $data->user->email ?? '-' }}</p></td>
                  <td><p class="text-sm font-weight-bold mb-0">{{ $data->event->nama ?? '-' }}</p></td>
                  <td>
                    @if($data->status_pembayaran === 'diterima')
                      <span class="badge bg-success">Diterima</span>
                    @elseif($data->status_pembayaran === 'ditolak')
                      <span class="badge bg-danger">Ditolak</span>
                    @else
                      <span class="badge bg-warning text-dark">Menunggu</span>
                    @endif
                  </td>
                  <td>
                    @if($data->bukti_bayar)
                    <button type="button" class="btn btn-sm btn-primary"
                      onclick="previewImage('{{ asset('storage/' . $data->bukti_bayar) }}', 'Bukti Pembayaran')">
                      Lihat
                    </button>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td class="text-center">
                    @if($data->status_pembayaran === 'menunggu')
                    <form action="{{ route('keuangan.prosesPembayaran', $data->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      <input type="hidden" name="status" value="diterima">
                      <button type="submit" class="btn btn-sm btn-success"
                        onclick="return confirm('Terima pembayaran peserta ini?')">Terima</button>
                    </form>

                    <form action="{{ route('keuangan.prosesPembayaran', $data->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      <input type="hidden" name="status" value="ditolak">
                      <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Tolak pembayaran peserta ini?')">Tolak</button>
                    </form>
                    @elseif($data->status_pembayaran === 'diterima')
                    <span class="text-success font-weight-bold">Pembayaran Diterima</span>
                    @elseif($data->status_pembayaran === 'ditolak')
                    <span class="text-danger font-weight-bold">Pembayaran Ditolak</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif

          @if(method_exists($pendaftaran, 'links'))
          <div class="mt-3 px-3">
            {{ $pendaftaran->links() }}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Bukti Bayar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imagePreviewModalLabel">Bukti Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imagePreview" src="" alt="Bukti Pembayaran" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<script>
  function previewImage(url, title) {
    document.getElementById('imagePreview').src = url;
    document.getElementById('imagePreviewModalLabel').innerText = title;
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
  }
</script>
@endsection
