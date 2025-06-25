<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranEvent;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KeuanganPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pendaftaran = PendaftaranEvent::with(['user', 'event'])
            ->where('status_pembayaran', 'menunggu')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($qUser) use ($search) {
                        $qUser->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('event', function ($qEvent) use ($search) {
                        $qEvent->where('nama', 'like', '%' . $search . '%');
                    })->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('keuangan.dashboard', compact('pendaftaran', 'search'));
    }


    public function prosesPembayaran(Request $request, $id)
    {
        $pendaftaran = PendaftaranEvent::findOrFail($id);
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $status = $request->status;
        $updateData = ['status_pembayaran' => $status];

        if ($status === 'diterima') {
            $qrData = json_encode([
                'pendaftaran_event_id' => $pendaftaran->id,
                'user_id' => $pendaftaran->user_id,
                'event_id' => $pendaftaran->event_id,
            ]);

            $qrCodePath = 'qrcodes/' . $pendaftaran->id . '.png';
            $qrImage = QrCode::format('png')->size(300)->generate($qrData);
            Storage::disk('public')->put($qrCodePath, $qrImage);

            $updateData['qr_code'] = $qrCodePath;

        } elseif ($status === 'ditolak') {
            if ($pendaftaran->qr_code && Storage::disk('public')->exists($pendaftaran->qr_code)) {
                Storage::disk('public')->delete($pendaftaran->qr_code);
            }
            $updateData['qr_code'] = null;
        }

        $pendaftaran->update($updateData);
        $message = $status === 'diterima' 
            ? 'Pembayaran berhasil diterima dan QR Code telah dibuat.' 
            : 'Pembayaran ditolak dan QR Code dihapus (jika ada).';

        return back()->with('success', $message);
    }

    public function selesai(Request $request)
    {
        $search = $request->input('search');

        $pendaftaran = PendaftaranEvent::with(['user', 'event'])
            ->whereIn('status_pembayaran', ['diterima', 'ditolak'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($qUser) use ($search) {
                        $qUser->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('event', function ($qEvent) use ($search) {
                        $qEvent->where('nama', 'like', '%' . $search . '%');
                    })->orWhere('id', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('keuangan.selesai', compact('pendaftaran', 'search'));
    }

}
