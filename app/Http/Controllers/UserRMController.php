<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRMController extends Controller
{
    public function index()
    {
        $users = DB::table('UserRM')
            ->orderBy('Nama')
            ->get();

        return view('user-rm.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama' => 'required',
            'Username' => 'required|unique:UserRM,Username',
            'Password' => 'required',
            'Role' => 'required',
        ]);

        DB::table('UserRM')->insert([
            'Nama' => $request->Nama,
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password),
            'Role' => $request->Role,
            'Aktif' => $request->Aktif ?? 1,
            'CreatedAt' => now(),
        ]);

        return redirect()
            ->route('userrm.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama' => 'required',
            'Username' => 'required',
            'Role' => 'required',
            'Aktif' => 'required',
        ]);

        $data = [
            'Nama' => $request->Nama,
            'Username' => $request->Username,
            'Role' => $request->Role,
            'Aktif' => $request->Aktif,
        ];

        if ($request->filled('Password')) {
            $data['Password'] = Hash::make($request->Password);
        }

        DB::table('UserRM')
            ->where('ID', $id)
            ->update($data);

        return redirect()
            ->route('userrm.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('UserRM')
            ->where('ID', $id)
            ->delete();

        return redirect()
            ->route('userrm.index')
            ->with('success', 'User berhasil dihapus.');
    }
}