@extends('layouts.app2')

@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid py-2">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif
    <div class="card my-4">

    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
      <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
      <h6 class="text-white text-capitalize ps-3">Events </h6>
      </div>
    </div>
    <br>



    <br>
    <div class="row">
      @foreach($events as $event)
      @php
      $sudahDaftar = in_array($event->id, $eventSudahDaftar);
      $eventSudahLewat = \Carbon\Carbon::parse($event->tanggal)->isPast();
      @endphp

      <div class="col-md-6 mb-4">
      <div class="card h-100 shadow-lg border-0" style="min-height: 580px;">
        <!-- Gambar poster bisa di klik untuk preview modal -->
        <img src="{{ asset('storage/' . $event->poster) }}" class="card-img-top cursor-pointer"
        style="height: 280px; object-fit: cover;" alt="Poster {{ $event->nama }}" data-bs-toggle="modal"
        data-bs-target="#previewModal" data-img="{{ asset('storage/' . $event->poster) }}">
        <br>
        <div class="card-body d-flex flex-column">
        <h4 class="card-title fw-bold mb-3 text-center text-dark">{{ $event->nama }}</h4>

        <ul class="list-group list-group-flush mb-3" style="font-size: 15px;">
        <li class="list-group-item px-0 d-flex align-items-center">
        <i class="fa fa-users me-2 text-primary"></i>
        <span class="fw-semibold">Maks Peserta:</span> &nbsp; {{ $event->jumlah_peserta }}
        </li>
        <li class="list-group-item px-0 d-flex align-items-center">
        <i class="fa fa-calendar-alt me-2 text-success"></i>
        <span class="fw-semibold">Tanggal & Waktu:</span> &nbsp;
        {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }} |
        {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
        </li>
        <li class="list-group-item px-0 d-flex align-items-center">
        <i class="fa fa-map-marker-alt me-2 text-danger"></i>
        <span class="fw-semibold">Lokasi:</span> &nbsp; {{ $event->lokasi }}
        </li>
        <li class="list-group-item px-0 d-flex align-items-center">
        <i class="fa fa-user-tie me-2 text-info"></i>
        <span class="fw-semibold">Narasumber:</span> &nbsp; {{ $event->narasumber }}
        </li>
        <li class="list-group-item px-0 d-flex align-items-center">
        <i class="fa fa-money-bill-wave me-2 text-warning"></i>
        <span class="fw-semibold">Biaya:</span> &nbsp; Rp {{ number_format($event->biaya, 0, ',', '.') }}
        </li>
        </ul>

        @php
        $pendaftaran = \App\Models\PendaftaranEvent::where('event_id', $event->id)
        ->where('user_id', auth()->id())
        ->latest()
        ->first();

        $status = $pendaftaran?->status_pembayaran;
        $eventSudahLewat = \Carbon\Carbon::parse($event->tanggal)->isPast();
      @endphp

        @if($status === 'menunggu')
      <button class="btn btn-warning mt-auto w-100 py-2">
        Menunggu Konfrimasi <i class="fa fa-hourglass-half me-1"></i>
      </button>
      @elseif($status === 'diterima')
      <button class="btn btn-success mt-auto w-100 py-2">
        Sudah Terdaftar <i class="fa fa-check me-1"></i>
      </button>
      @elseif($status === 'ditolak')
      <button class="btn btn-danger mt-auto w-100 py-2">
        Pendaftaran Ditolak <i class="fa fa-times me-1"></i>
      </button>
      @elseif($eventSudahLewat)
      <button class="btn btn-dark mt-auto w-100 py-2">
        <i class="fa fa-calendar-times me-1"></i> Event Sudah Lewat
      </button>
      @else
      <a href="{{ route('event.daftar', $event->id) }}" class="btn btn-primary mt-auto w-100 py-2">
        <i class="fa fa-edit me-1"></i> Daftar Sekarang
      </a>
      @endif

        </div>
      </div>
      </div>
    @endforeach
    </div>
    </div>

    <!-- Modal Preview Gambar -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid rounded" alt="Preview Gambar">
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
      </div>
    </div>
    </div>

  </div>

  <!-- Script untuk ganti gambar modal saat preview -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    var previewModal = document.getElementById('previewModal')
    var modalImage = document.getElementById('modalImage')

    previewModal.addEventListener('show.bs.modal', function (event) {
      var triggerImg = event.relatedTarget
      var imgSrc = triggerImg.getAttribute('data-img')
      modalImage.src = imgSrc
      modalImage.alt = triggerImg.alt
    })

    previewModal.addEventListener('hidden.bs.modal', function () {
      modalImage.src = ''
      modalImage.alt = ''
    })
    })
  </script>
@endsection