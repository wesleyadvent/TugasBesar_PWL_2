<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\PendaftaranEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PendaftaranEventController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $eventSudahDaftar = PendaftaranEvent::where('user_id', $userId)->pluck('event_id')->toArray();
        $events = Event::all();

        return view('member.dashboard', compact('events', 'eventSudahDaftar'));
    }

    public function daftarSaya()
    {
        $userId = Auth::id();

        $pendaftaran = PendaftaranEvent::with(['event', 'kehadiran.sertifikat'])
            ->where('user_id', $userId)
            ->get();

        return view('member.event_saya', compact('pendaftaran'));
    }

    public function showForm($id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        return view('member.daftar_event', compact('event', 'user'));
    }


public function store(Request $request)
{
    $request->validate([
        'event_id' => 'required|exists:event,id',
        'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $userId = Auth::id();
    $eventId = $request->event_id;
    $sudahDaftar = PendaftaranEvent::where('user_id', $userId)
        ->where('event_id', $eventId)
        ->exists();

    if ($sudahDaftar) {
        return redirect()->route('member.dashboard')
            ->with('error', 'Kamu sudah mendaftar event ini sebelumnya.');
    }

    $count = PendaftaranEvent::where('user_id', $userId)->count() + 1;
    $nomorUrut = str_pad($count, 2, '0', STR_PAD_LEFT);
    $customId = "pd-{$userId}-{$nomorUrut}";

    $buktiBayarPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

    PendaftaranEvent::create([
        'id' => $customId,
        'event_id' => $eventId,
        'user_id' => $userId,
        'status_pembayaran' => 'menunggu',
        'qr_code' => null,
        'bukti_bayar' => $buktiBayarPath,
    ]);

    return redirect()->route('member.dashboard')->with('success', 'Pendaftaran berhasil! Menunggu konfirmasi pembayaran.');
}

    public function showQR($id)
    {
        $pendaftaran = PendaftaranEvent::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('member.qr_code', compact('pendaftaran'));
    }

    
}
