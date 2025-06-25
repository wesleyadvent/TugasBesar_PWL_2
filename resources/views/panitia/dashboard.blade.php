@extends('layouts.app2')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    @forelse($events as $event)
      @php
        $jumlahTerdaftar = $event->jumlah_terdaftar ?? 0;
        $jumlahMaks = $event->jumlah_peserta ?? 10;
        $progress = $jumlahMaks > 0 ? ($jumlahTerdaftar / $jumlahMaks) * 100 : 0;
      @endphp

      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100 border-0 rounded-4">
          <div class="row g-0">
            <div class="col-md-5">
              <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->nama }}" class="img-fluid rounded-start h-100 object-fit-cover" style="border-top-left-radius: 0.75rem; border-bottom-left-radius: 0.75rem;">
            </div>
            <div class="col-md-7">
              <div class="card-body d-flex flex-column h-100">
                <h4 class="card-title mb-2">{{ $event->nama }}</h4>

                <div class="mb-2">
                  <span class="badge bg-primary me-2"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</span>
                  <span class="badge bg-info text-dark"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }}</span>
                  @if(\Carbon\Carbon::parse($event->tanggal)->isPast())
                    <span class="badge bg-danger">Sudah Lewat</span>
                  @else
                    <span class="badge bg-success">Akan Datang</span>
                  @endif
                </div>

                <p class="mb-1"><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                <p class="mb-1"><strong>Narasumber:</strong> {{ $event->narasumber }}</p>
                <p class="mb-1"><strong>Biaya:</strong> Rp {{ number_format($event->biaya, 0, ',', '.') }}</p>

                <div class="mt-auto">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted"><strong>Peserta:</strong> {{ $jumlahTerdaftar }}/{{ $jumlahMaks }}</small>
                    <small class="text-muted">{{ number_format($progress, 0) }}%</small>
                  </div>
                  <div class="progress" style="height: 12px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <p class="text-muted">Belum ada event yang terdaftar.</p>
    @endforelse
  </div>
</div>
@endsection
