@extends('layouts.app2')

@section('title', 'Dashboard Keuangan - Data Pembayaran Selesai')

@section('content')
<div class="container-fluid py-2">
  <form method="GET" action="{{ route('keuangan.selesai') }}" class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">

    <!-- Input Pencarian -->
    <div class="input-group input-group-dynamic mb-4" style="max-width: 350px;">
      <input type="text" name="search" class="form-control" value="{{ request('search') }}"
        placeholder="Cari nama..." aria-label="Cari berdasarkan nama">
    </div>

    <button type="submit" class="btn btn-primary mb-3">
      <i class="fa fa-search me-1"></i> Cari
    </button>

    @if(request('search'))
      <a href="{{ route('keuangan.selesai', request()->except('search')) }}"
        class="btn btn-outline-secondary" title="Hapus pencarian">
        <i class="bi bi-x-circle"></i>
      </a>
    @endif
  </form>

  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Daftar Pembayaran Sudah Dikonfirmasi</h6>
          </div>
        </div>

        <div class="card-body px-0 pb-2">
          @if(session('success'))
            <div class="alert alert-success mx-3">{{ session('success') }}</div>
          @elseif(session('error'))
            <div class="alert alert-danger mx-3">{{ session('error') }}</div>
          @endif

          @if($pendaftaran->isEmpty())
            <p class="text-center text-muted py-5">
              <i class="fa fa-calendar-check fa-2x d-block mb-2"></i>
              Tidak ada data pembayaran selesai.
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
                    <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">QR Code</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pendaftaran as $data)
                    <tr>
                      <td>
                        <p class="text-sm font-weight-bold mb-0 ps-3">{{ $data->id }}</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $data->user->name ?? '-' }}</p>
                      </td>
                      <td>
                        <p class="text-sm text-muted mb-0">{{ $data->user->email ?? '-' }}</p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $data->event->nama ?? '-' }}</p>
                      </td>
                      <td>
                        @if($data->status_pembayaran === 'diterima')
                          <span class="badge bg-success">Diterima</span>
                        @elseif($data->status_pembayaran === 'ditolak')
                          <span class="badge bg-danger">Ditolak</span>
                        @else
                          <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
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
                      <td>
                        @if($data->qr_code)
                          <button type="button" class="btn btn-sm btn-primary"
                            onclick="previewImage('{{ asset('storage/' . $data->qr_code) }}', 'QR Code')">
                            Lihat QR
                          </button>
                        @else
                          <span class="text-muted">Tidak tersedia</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imagePreviewModalLabel">Preview Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imagePreview" src="" alt="Gambar" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>

<script>
  function previewImage(url, title) {
    const modalTitle = document.getElementById('imagePreviewModalLabel');
    const modalImage = document.getElementById('imagePreview');
    modalTitle.textContent = title;
    modalImage.src = url;

    const imageModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    imageModal.show();
  }
</script>
@endsection
