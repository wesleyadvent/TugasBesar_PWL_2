@extends('layouts.app2')

@section('title', 'Pembayaran Terkonfirmasi')

@section('content')
<div class="container">
    <h1>Pendaftaran Event - Pembayaran Terkonfirmasi</h1>

    <a href="{{ route('keuangan.dashboard') }}" class="btn btn-primary mb-3">Lihat Belum Bayar</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Peserta</th>
                <th>Event</th>
                <th>Status Pembayaran</th>
                <th>QR Code</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendaftaran as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->event->nama_event }}</td>
                    <td>
                        <span class="badge bg-success">{{ ucfirst($item->status_pembayaran) }}</span>
                    </td>
                    <td>
                        @if($item->qr_code)
                            <img src="{{ asset('storage/' . $item->qr_code) }}" alt="QR Code" width="100" height="100">
                        @else
                            Tidak ada QR Code
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada pendaftaran yang sudah dikonfirmasi pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
