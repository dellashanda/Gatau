<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Mengambil objek pengguna saat ini
        $user = Auth::user();

        // Memeriksa peran pengguna
        if ($user->role === 'kasir') {
            return view('kasir.dashboard');
        }else if ($user->role === 'kepala_toko') {
            return view('kepala_toko.dashboard');
        } else if ($user->role === 'ketua_koperasi') {
            return view('ketua_koperasi.dashboard');
        } else if ($user->role === 'keuangan') {
            return view('keuangan.dashboard');
        } else if ($user->role === 'admin') {
            return view('admin.dashboard');
        }
    }
}

