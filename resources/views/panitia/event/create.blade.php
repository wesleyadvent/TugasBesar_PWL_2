@extends('layouts.app2')

@section('title', 'Tambah Event')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Tambah Event Baru</h6>
                        </div>
                    </div>
                    <div class="card-body px-4 pt-4">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('warning'))
                            <div class="alert alert-warning">{{ session('warning') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('panitia.event.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="nama" class="form-label fw-bold">Nama Event</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-bullhorn"></i></span>
                                        <input type="text" name="nama" id="nama" class="form-control"
                                            value="{{ old('nama') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label fw-bold">Lokasi</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-map-marker-alt"></i></span>
                                        <input type="text" name="lokasi" id="lokasi" class="form-control"
                                            value="{{ old('lokasi') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="narasumber" class="form-label fw-bold">Narasumber</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-user-tie"></i></span>
                                        <input type="text" name="narasumber" id="narasumber" class="form-control"
                                            value="{{ old('narasumber') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-calendar-alt"></i></span>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                                            value="{{ old('tanggal') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="waktu" class="form-label fw-bold">Waktu Mulai</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-clock"></i></span>
                                        <input type="time" name="waktu" id="waktu" class="form-control"
                                            value="{{ old('waktu') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="waktu_selesai" class="form-label fw-bold">Waktu Selesai</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-clock"></i></span>
                                        <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                                            value="{{ old('waktu_selesai') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="poster" class="form-label fw-bold">Poster</label>
                                    <div class="input-group input-group-outline">
                                        <input type="file" name="poster" id="poster" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="biaya" class="form-label fw-bold">Biaya (Rp)</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-money-bill-wave"></i></span>
                                        <input type="number" name="biaya" id="biaya" class="form-control"
                                            value="{{ old('biaya', 0) }}" min="0" required>
                                    </div>
                                    <small class="text-muted ps-3">Isi 0 jika gratis</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="jumlah_peserta" class="form-label fw-bold">Jumlah Peserta</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <span class="input-group-text me-2"><i class="fa fa-users"></i></span>
                                        <input type="number" name="jumlah_peserta" id="jumlah_peserta" class="form-control"
                                            value="{{ old('jumlah_peserta', 0) }}" min="0" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="users_id" class="form-label fw-bold">Penanggung Jawab</label>
                                    <select name="users_id" id="users_id" class="form-select" required>
                                        <option value="" disabled {{ old('users_id') ? '' : 'selected' }}>-- Pilih
                                            Penanggung Jawab --</option>
                                        @foreach($panitias as $user)
                                            <option value="{{ $user->id }}" {{ old('users_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
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
                                    <i class="fa fa-check-circle me-1"></i> Simpan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection