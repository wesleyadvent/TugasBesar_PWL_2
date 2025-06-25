<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class AdministratorController extends Controller
{
    public function dashboard()
    {
        $roles = ['panitia', 'keuangan', 'administrator', 'member'];

        $userCounts = [];
        foreach ($roles as $role) {
            $userCounts[$role] = FacadesDB::table('users')->where('role', $role)->count();
        }

        return view('administrator.dashboard', compact('userCounts'));
    }

}
