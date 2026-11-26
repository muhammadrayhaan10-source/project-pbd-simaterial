<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('iduser')) {
            return redirect('/login')->withErrors([
                'error' => 'Silakan login terlebih dahulu.',
            ]);
        }

        $namaRole = (string) session('nama_role', 'User');
        $roleKey  = strtolower(trim($namaRole));

        // Ringkasan data cepat dengan Raw SQL
        $totalBarang     = (DB::select('SELECT COUNT(*) AS total FROM barang')[0]->total) ?? 0;
        $totalPengadaan  = (DB::select('SELECT COUNT(*) AS total FROM pengadaan')[0]->total) ?? 0;
        $totalPenerimaan = (DB::select('SELECT COUNT(*) AS total FROM penerimaan')[0]->total) ?? 0;
        $totalPenjualan  = (DB::select('SELECT COUNT(*) AS total FROM penjualan')[0]->total) ?? 0;

        // Tentukan view dashboard berdasarkan role login
        if (str_contains($roleKey, 'admin')) {
            $viewName = 'admin.dashboard';
        } elseif (str_contains($roleKey, 'owner')) {
            $viewName = 'owner.dashboard';
        } elseif (str_contains($roleKey, 'pengadaan') || str_contains($roleKey, 'purchasing')) {
            $viewName = 'admin.pengadaan.dashboard';
        } else {
            $viewName = 'umum.dashboard';
        }

        return view($viewName, [
            'username'        => session('username'),
            'namaRole'        => $namaRole,
            'totalBarang'     => $totalBarang,
            'totalPengadaan'  => $totalPengadaan,
            'totalPenerimaan' => $totalPenerimaan,
            'totalPenjualan'  => $totalPenjualan,
        ]);
    }
}
