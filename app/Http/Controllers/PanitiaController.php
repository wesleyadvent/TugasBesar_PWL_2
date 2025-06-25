<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PanitiaController extends Controller
{
    public function dashboard()
    {
        $events = Event::withCount([
            'pendaftarans as jumlah_terdaftar' => function ($query) {
                $query->where('status_pembayaran', 'diterima');
            }
        ])->orderBy('tanggal', 'desc')->get();

        return view('panitia.dashboard', compact('events'));
    }

}
