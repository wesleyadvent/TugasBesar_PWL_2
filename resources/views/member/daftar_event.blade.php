@extends('layouts.app2')

@section('title', 'Daftar Event')

@section('content')
    <div class="container-fluid py-2">

  {{-- Flash Messages --}}
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(session('success'))
  <div class="alert alert-success"><i class="fa fa-check-circle me-1"></i> {{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div class="alert alert-danger"><i class="fa fa-times-circle me-1"></i> {{ session('error') }}</div>
  @endif
  @if(session('warning'))
  <div class="alert alert-warning"><i class="fa fa-exclamation-triangle me-1"></i> {{ session('warning') }}</div>
  @endif

  {{-- Event Card --}}

        <div class="row">
      <div class="col-12">
      <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Form Pendaftaran</h6>
        </div>
        </div>

        <div class="card-body px-4 pt-4">

          {{-- Informasi Event --}}
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nama Event</label>
              <div class="input-group input-group-outline">
                <span class="input-group-text me-2"><i class="fa fa-bullhorn"></i></span>
                <input type="text" class="form-control" value="{{ $event->nama }}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Tanggal & Waktu</label>
              <div class="input-group input-group-outline">
                <span class="input-group-text me-2"><i class="fa fa-clock"></i></span>
                <input type="text" class="form-control"
                  value="{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }} | {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB"
                  readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Lokasi</label>
              <div class="input-group input-group-outline">
                <span class="input-group-text me-2"><i class="fa fa-map-marker-alt"></i></span>
                <input type="text" class="form-control" value="{{ $event->lokasi }}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Narasumber</label>
              <div class="input-group input-group-outline">
                <span class="input-group-text me-2"><i class="fa fa-user-tie"></i></span>
                <input type="text" class="form-control" value="{{ $event->narasumber }}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Biaya</label>
              <div class="input-group input-group-outline">
                <span class="input-group-text me-2"><i class="fa fa-money-bill-wave"></i></span>
                <input type="text" class="form-control" value="{{ $event->biaya }}" readonly>
              </div>
            </div>
          </div>

          {{-- Form Pendaftaran --}}
          <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Nama Anda</label>
                <div class="input-group input-group-outline">
                  <span class="input-group-text me-2"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <div class="input-group input-group-outline">
                  <span class="input-group-text "><i class="fa fa-envelope"></i></span>
                  <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Upload Bukti Pembayaran</label>
                <p class="text-muted small">Silakan unggah bukti pembayaran untuk menyelesaikan pendaftaran.</p>
                <div class="input-group input-group-outline">
                  <input type="file" name="bukti_bayar" class="form-control @error('bukti_bayar') is-invalid @enderror"
                    required>
                </div>
                @error('bukti_bayar')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Kembali
              </a>
              <button type="submit" class="btn btn-success">
                <i class="fa fa-check-circle me-1"></i> Daftar Sekarang
              </button>
            </div>
          </form>
        </div> {{-- card-body --}}
      </div> {{-- card --}}
    </div>


@endsection
