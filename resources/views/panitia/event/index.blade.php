@extends('layouts.app2')

@section('title', 'Daftar Event')

@section('content')

    <div class="container-fluid py-2">
        <div class="row mb-4">
            <div class="d-flex flex-wrap align-items-center gap-3" style="max-width: 900px;">

                <a href="{{ route('panitia.event.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Tambah Event
                </a>
                <!-- Form Search -->
                <form method="GET" action="{{ route('panitia.event.index') }}"
                    class="d-flex flex-wrap align-items-center gap-3 flex-grow-1">

                    <!-- Input Pencarian -->
                    <div class=" input-group input-group-dynamic mb-4" style="max-width: 350px; max-height: 10;">
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="Cari nama..." aria-label="Cari berdasarkan nama">


                    </div>
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="fa fa-search me-1"></i> Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('panitia.event.index', request()->except('search')) }}"
                            class="btn btn-outline-secondary" title="Hapus pencarian">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>


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
                            <h6 class="text-white text-capitalize ps-3">Events Table</h6>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0" style="overflow: visible;">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-3">
                                            Nama</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">
                                            Tanggal</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">
                                            Lokasi</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">
                                            Biaya</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-100 ps-2">
                                            Maks Peserta</th>
                                        <th></th> <!-- Kolom Aksi -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0 ps-3">{{ $event->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ \Carbon\Carbon::parse($event->tanggal)->format('d-m-Y') }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $event->lokasi }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $event->biaya == 0 ? 'Gratis' : 'Rp ' . number_format($event->biaya, 0, ',', '.') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $event->jumlah_peserta }}</p>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="dropdown text-end">
                                                    <button class="btn btn-link text-secondary p-0" type="button"
                                                        id="dropdownMenuButton{{ $event->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v text-xs"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3"
                                                        aria-labelledby="dropdownMenuButton{{ $event->id }}">
                                                        <li>
                                                            <button class="dropdown-item border-radius-md" type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#detailEventModal{{ $event->id }}">
                                                                <i class="fa fa-info-circle me-2"></i>Lihat Selengkapnya
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item border-radius-md"
                                                                href="{{ route('panitia.event.edit', $event->id) }}">
                                                                <i class="fa fa-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('panitia.event.destroy', $event->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin hapus event ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="dropdown-item border-radius-md text-danger">
                                                                    <i class="fa fa-trash me-2"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal Detail Event -->
                                        <div class="modal fade" id="detailEventModal{{ $event->id }}" tabindex="-1"
                                            aria-labelledby="detailEventLabel{{ $event->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content shadow-lg border-0 rounded-4">
                                                    <div class="modal-header bg-dark text-white rounded-top-4">
                                                        <h5 class="modal-title fw-bold text-white" id="detailEventLabel{{ $event->id }}">
                                                            <i class="fa fa-calendar-check me-2 text-white"></i> Detail Event
                                                            {{ $event->nama }}
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row g-4">
                                                            <!-- Poster -->
                                                            <div
                                                                class="col-lg-6 d-flex justify-content-center align-items-center">
                                                                @if($event->poster)
                                                                    <img src="{{ asset('storage/' . $event->poster) }}"
                                                                        alt="Poster Event {{ $event->nama }}"
                                                                        class="img-fluid rounded-4 shadow-lg poster-hover"
                                                                        style="max-height: 450px; object-fit: cover; width: 100%; max-width: 400px;">
                                                                @else
                                                                    <div
                                                                        class="text-muted fst-italic text-center py-5 w-100 border rounded-4">
                                                                        <i class="fa fa-image fa-3x mb-3"></i><br>
                                                                        Poster tidak tersedia
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Detail Info -->
                                                            <div class="col-lg-6">
                                                                <ul class="list-unstyled fs-6">
                                                                    <li class="mb-3">
                                                                        <strong><i
                                                                                class="fa fa-calendar-alt text-primary me-2"></i>Tanggal:</strong>
                                                                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}
                                                                    </li>
                                                                    <li class="mb-3">
                                                                        <strong><i class="fa fa-clock text-primary me-2"></i>Waktu:</strong>
                                                                        {{ $event->waktu }} - {{ $event->waktu_selesai }}
                                                                    </li>

                                                                    <li class="mb-3">
                                                                        <strong><i
                                                                                class="fa fa-map-marker-alt text-primary me-2"></i>Lokasi:</strong>
                                                                        {{ $event->lokasi }}
                                                                    </li>
                                                                    <li class="mb-3">
                                                                        <strong><i
                                                                                class="fa fa-microphone text-primary me-2"></i>Narasumber:</strong>
                                                                        {{ $event->narasumber }}
                                                                    </li>
                                                                    <li class="mb-3">
                                                                        <strong><i
                                                                                class="fa fa-ticket-alt text-primary me-2"></i>Biaya:</strong>
                                                                        {{ $event->biaya == 0 ? 'Gratis' : 'Rp ' . number_format($event->biaya, 0, ',', '.') }}
                                                                    </li>
                                                                    <li class="mb-3">
                                                                        <strong><i
                                                                                class="fa fa-users text-primary me-2"></i>Jumlah
                                                                            Maks Peserta:</strong> {{ $event->jumlah_peserta }}
                                                                    </li>
                                                                    <li class="mb-3">
                                                                        <strong><i
                                                                                class="fa fa-user text-primary me-2"></i>Penanggung
                                                                            Jawab:</strong>
                                                                        {{ $event->user ? $event->user->name : '-' }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-primary rounded-pill px-4"
                                                            data-bs-dismiss="modal">
                                                            <i class="fa fa-times me-2"></i>Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
       


                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <i class="fa fa-calendar-times fa-2x d-block mb-2"></i>
                                                Tidak ada data event.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3 px-3">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection