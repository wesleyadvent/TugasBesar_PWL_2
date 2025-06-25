<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
public function index(Request $request)
{
    $roleFilter = $request->input('role');
    $searchName = $request->input('search');

    $query = User::query();
    $query->whereIn('role', ['panitia', 'keuangan']);

    if (in_array($roleFilter, ['panitia', 'keuangan'])) {
        $query->where('role', $roleFilter);
    }

    if ($searchName) {
        $query->where('name', 'like', '%' . $searchName . '%');
    }

    $users = $query->paginate(10)->withQueryString();

    return view('administrator.users.index', compact('users', 'roleFilter', 'searchName'));
}


    public function create()
    {
        $roles = ['keuangan', 'panitia'];
        $statuses = ['aktif', 'nonaktif'];
        return view('administrator.users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['keuangan', 'panitia'])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);


        return redirect()->route('administrator.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = ['keuangan', 'panitia'];
        $statuses = ['aktif', 'nonaktif'];
        return view('administrator.users.edit', compact('user', 'roles', 'statuses'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['keuangan', 'panitia'])],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('administrator.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('administrator.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();

        return redirect()->route('administrator.users.index')->with('success', 'Status user berhasil diubah.');
    }
}
