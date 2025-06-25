<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    private function generateId($date)
    {
        $year = $date->format('Y');
        $month = $date->format('m');

        $count = Event::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->count();

        $nextNumber = $count + 1;

        return sprintf('ev-%s-%s-%03d', $year, $month, $nextNumber);
    }

    public function index(Request $request)
    {
        $query = \App\Models\Event::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('narasumber', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        return view('panitia.event.index', compact('events'));
    }

    public function index2()
    {
        $events = Event::orderBy('tanggal', 'desc')->get();
        return view('welcome', compact('events'));
    }

    

    public function create()
    {
        $panitias = User::where('role', 'panitia')->get();
        return view('panitia.event.create', compact('panitias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'narasumber' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'waktu_selesai' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biaya' => 'required|numeric|min:0',
            'jumlah_peserta' => 'required|integer|min:0',
            'users_id' => 'required|exists:users,id',
        ]);

        // Validasi bahwa waktu_selesai > waktu
        $start = \Carbon\Carbon::createFromFormat('H:i', $validated['waktu']);
        $end = \Carbon\Carbon::createFromFormat('H:i', $validated['waktu_selesai']);
        if ($end->lessThanOrEqualTo($start)) {
            return back()->withErrors(['waktu_selesai' => 'Waktu selesai harus lebih dari waktu mulai'])->withInput();
        }

        $tanggal = \Carbon\Carbon::parse($validated['tanggal']);
        $id = $this->generateId($tanggal);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        Event::create([
            'id' => $id,
            'nama' => $validated['nama'],
            'lokasi' => $validated['lokasi'],
            'narasumber' => $validated['narasumber'],
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'poster' => $posterPath,
            'biaya' => $validated['biaya'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'users_id' => $validated['users_id'],
        ]);

        return redirect()->route('panitia.event.index')->with('success', 'Event berhasil dibuat');
    }


    public function show(Event $event)
    {
        return view('panitia.event.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $panitias = User::where('role', 'panitia')->get();

        return view('panitia.event.edit', compact('event', 'panitias'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'narasumber' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'waktu_selesai' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biaya' => 'required|numeric|min:0',
            'jumlah_peserta' => 'required|integer|min:0',
            'users_id' => 'required|exists:users,id',
        ]);

        $start = \Carbon\Carbon::createFromFormat('H:i', $validated['waktu']);
        $end = \Carbon\Carbon::createFromFormat('H:i', $validated['waktu_selesai']);
        if ($end->lessThanOrEqualTo($start)) {
            return back()->withErrors(['waktu_selesai' => 'Waktu selesai harus lebih dari waktu mulai'])->withInput();
        }

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
            $event->poster = $posterPath;
        }

        $event->update([
            'nama' => $validated['nama'],
            'lokasi' => $validated['lokasi'],
            'narasumber' => $validated['narasumber'],
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'biaya' => $validated['biaya'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'users_id' => $validated['users_id'],
        ]);

        return redirect()->route('panitia.event.index')->with('success', 'Event berhasil diperbarui');
    }


    public function destroy(Event $event)
    {
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('panitia.event.index')->with('success', 'Event berhasil dihapus');
    }
}
