@extends('layouts.app2')

@section('title', 'Edit Event')

@section('content')
<div class="container-fluid py-2">
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Edit Event</h6>
            </div>
        </div>

        <div class="card-body px-4 pt-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Ada masalah dengan inputanmu:<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('panitia.event.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama" class="form-label fw-bold">Nama Event</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text me-2"><i class="fa fa-bullhorn"></i></span>
                            <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $event->nama) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="lokasi" class="form-label fw-bold">Lokasi</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text me-2"><i class="fa fa-map-marker-alt"></i></span>
                            <input type="text" name="lokasi" class="form-control" id="lokasi" value="{{ old('lokasi', $event->lokasi) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="narasumber" class="form-label fw-bold">Narasumber</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text me-2"><i class="fa fa-user-tie"></i></span>
                            <input type="text" name="narasumber" class="form-control" id="narasumber" value="{{ old('narasumber', $event->narasumber) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text me-2"><i class="fa fa-calendar"></i></span>
                            <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ old('tanggal', $event->tanggal) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="waktu" class="form-label fw-bold">Waktu</label>
                        <div class="input-group input-group-outline">
                            <input type="time" name="waktu" class="form-control" id="waktu" value="{{ old('waktu', $event->waktu) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="waktu_selesai" class="form-label fw-bold">Waktu Selesai</label>
                        <div class="input-group input-group-outline">
                            <input type="time" name="waktu_selesai" class="form-control" id="waktu_selesai" value="{{ old('waktu_selesai', $event->waktu_selesai) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="poster" class="form-label fw-bold">Poster (biarkan kosong jika tidak ingin mengubah)</label>
                        <div class="input-group input-group-outline">
                            <input type="file" name="poster" class="form-control" id="poster" accept="image/*">
                        </div>
                        @if ($event->poster)
                            <p class="mt-2">Poster saat ini:</p>
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" style="max-width: 200px;">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="biaya" class="form-label fw-bold">Biaya (0 jika gratis)</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text me-2"><i class="fa fa-money-bill-wave"></i></span>
                            <input type="number" name="biaya" class="form-control" id="biaya" value="{{ old('biaya', $event->biaya) }}" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="jumlah_peserta" class="form-label fw-bold">Jumlah Peserta</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text me-2"><i class="fa fa-users"></i></span>
                            <input type="number" name="jumlah_peserta" class="form-control" id="jumlah_peserta" value="{{ old('jumlah_peserta', $event->jumlah_peserta) }}" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="penanggung_jawab" class="form-label fw-bold">Penanggung Jawab</label>
                        <select name="users_id" id="penanggung_jawab" class="form-select" required>
                            <option value="" disabled {{ old('users_id', $event->users_id) ? '' : 'selected' }}>-- Pilih Penanggung Jawab --</option>
                            @foreach ($panitias as $panitia)
                                <option value="{{ $panitia->id }}" {{ old('users_id', $event->users_id) == $panitia->id ? 'selected' : '' }}>
                                    {{ $panitia->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('panitia.event.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-circle me-1"></i> Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
