<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class MemberController extends Controller
{
public function dashboard()
{
    $events = Event::orderBy('tanggal', 'desc')->get();
    return view('member.dashboard', compact('events'));
}

}
