<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PendaftaranEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberEventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('member.event.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('member.event.show', compact('event'));
    }

    public function daftar(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        $jumlahPesertaTerdaftar = PendaftaranEvent::where('event_id', $event->id)
            ->where('status_pembayaran', '!=', 'ditolak')
            ->count();

        if ($jumlahPesertaTerdaftar >= $event->jumlah_peserta) {
            return redirect()->back()->withErrors(['msg' => 'Pendaftaran sudah penuh, tidak bisa mendaftar lagi.']);
        }

        $pendaftaran = PendaftaranEvent::create([
            'id' => (string) Str::uuid(),
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status_pembayaran' => 'pending',
            'qr_code' => '',
            'created_at' => now(),
        ]);

        $qrContent = 'PendaftaranID:' . $pendaftaran->id;
        $qrImage = base64_encode(QrCode::format('png')->size(200)->generate($qrContent));
        $pendaftaran->qr_code = $qrImage;
        $pendaftaran->save();

        return redirect()->route('member.event.bayar', ['id' => $pendaftaran->id]);
    }


}
