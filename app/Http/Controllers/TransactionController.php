<?php

// untuk menangani data Pengadaan, Penerimaan, dan Penjualan
// TRANSAKSI MAKSUDNYA
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Menampilkan data pengadaan menggunakan MySQL View
    public function indexPengadaan()
    {
        $pengadaans = DB::select('SELECT * FROM view_pengadaan');
        return view('admin.pengadaan.index', compact('pengadaans'));
    }
    // Menampilkan data penerimaan menggunakan MySQL View
    public function indexPenerimaan()
    {
        $penerimaans = DB::select('SELECT * FROM view_penerimaan');
        return view('admin.penerimaan.index', compact('penerimaans'));
    }
    // Menampilkan data penjualan menggunakan MySQL View
    public function indexPenjualan()
    {
        $penjualans = DB::select('SELECT * FROM view_penjualan');
        return view('admin.penjualan.index', compact('penjualans'));
    }
}
