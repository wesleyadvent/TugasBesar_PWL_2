@extends('layouts.app2')

@section('title', 'Event yang Sudah Didaftarkan')

@section('content')
<div class="container-fluid py-2">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Event yang Sudah Didaftarkan</h6>
          </div>
        </div>

        <div class="card-body px-0 pb-2">
          @if(session('success'))
          <div class="alert alert-success mx-3">{{ session('success') }}</div>
          @endif

          @if($pendaftaran->isEmpty())
          <p class="text-center text-muted py-5">
            <i class="fa fa-calendar-times fa-2x d-block mb-2"></i>
            Kamu belum mendaftar ke event manapun.
          </p>
          @else
          <div class="table-responsive p-0" style="overflow: visible;">
            <table class="table align-items-center justify-content-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-3">Nama Event</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Status Pembayaran</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Bukti Bayar</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">QR Code</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Sertifikat</th>
                  <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Tanggal Daftar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pendaftaran as $data)
                <tr>
                  <td><p class="text-sm font-weight-bold mb-0 ps-3">{{ $data->event->nama ?? '-' }}</p></td>
                  <td>
                    @if($data->status_pembayaran === 'diterima')
                    <span class="badge bg-success">Lunas</span>
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
                    <div class="d-flex gap-2">
                      <button type="button" class="btn btn-sm btn-primary"
                        onclick="previewImage('{{ asset('storage/' . $data->qr_code) }}', 'QR Code')">
                        Lihat QR
                      </button>
                      <a href="{{ asset('storage/' . $data->qr_code) }}" download="QR_{{ Str::slug($data->event->nama) }}.png"
                        class="btn btn-sm btn-success">
                        Unduh QR
                      </a>
                    </div>
                    @else
                    <span class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">Belum tersedia</span>
                    @endif
                  </td>
                  <td>
                    @if($data->kehadiran && $data->kehadiran->sertifikat)
                    <a href="{{ asset('storage/' . $data->kehadiran->sertifikat->file_sertifikat) }}" class="btn btn-sm btn-success"
                      download>
                      Download Sertifikat
                    </a>
                    @else
                    <span class="text-muted">Belum tersedia</span>
                    @endif
                  </td>
                  <td><p class="text-sm text-muted mb-0">{{ $data->created_at->format('d M Y H:i') }}</p></td>
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

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
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
    document.getElementById('imagePreview').src = url;
    document.getElementById('imagePreviewModalLabel').innerText = title;
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
  }
</script>
@endsection
