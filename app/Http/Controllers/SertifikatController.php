<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kehadiran;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('panitia.sertifikat.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $kehadiran = Kehadiran::where('event_id', $id)->with(['user', 'sertifikat'])->get();
        return view('panitia.sertifikat.show', compact('event', 'kehadiran'));
    }

    public function upload(Request $request, $kehadiranId)
    {
        $request->validate([
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $file = $request->file('file_sertifikat');
        $path = $file->store('sertifikat', 'public');

        Sertifikat::updateOrCreate(
            ['kehadiran_id' => $kehadiranId],
            [
                'id' => (string) Str::uuid(),
                'file_sertifikat' => $path,
                'uploaded_at' => now()
            ]
        );

        return back()->with('success', 'Sertifikat berhasil diupload.');
    }
    
    public function download($kehadiranId)
    {
        $sertifikat = Sertifikat::where('kehadiran_id', $kehadiranId)->firstOrFail();

        $filePath = storage_path('app/public/' . $sertifikat->file_sertifikat);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File sertifikat tidak ditemukan.');
        }

        return response()->download($filePath);
    }


}
