<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRM;
use Illuminate\Support\Facades\Hash;

class AuthRMController extends Controller
{
    public function showLogin()
    {
        return view('auth-rm.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required',
        ]);

        $user = UserRM::where('Username', $request->Username)
            ->where('Aktif', 1)
            ->first();

        if (!$user || !Hash::check($request->Password, $user->Password)) {
            return back()->with('error', 'Username atau password salah.');
        }

        session([
            'user_rm_id' => $user->ID,
            'user_rm_nama' => $user->Nama,
            'user_rm_role' => $user->Role,
        ]);

       # return redirect()->route('user-rm.index');
        return redirect()->route('mjkn.batal-mjkn.index');
    }

    public function logout()
    {
        session()->forget(['user_rm_id', 'user_rm_nama', 'user_rm_role']);

        return redirect()->route('rm.login');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_baru' => 'required|min:1|confirmed',
        ]);

        $user = UserRM::find(session('user_rm_id'));

        if (!$user) {
            return back()->withErrors(['User tidak ditemukan.']);
        }

        $user->Password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}