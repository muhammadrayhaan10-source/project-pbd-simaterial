<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    // Menampilkan data barang menggunakan MySQL View
    public function indexBarang()
    {
        $barangs = DB::select('SELECT * FROM view_barang');
        return view('admin.barang.index', compact('barangs'));
    }

    // ==========================================
    // Fungsi untuk menampilkan form tambah barang dan menyimpan data barang baru
    // ==========================================
    public function createBarang()
    {
        // Mengambil data satuan yang aktif untuk pilihan dropdown
        $satuans = DB::select('SELECT * FROM satuan WHERE status = 1');
        return view('admin.barang.create', compact('satuans'));
    }

    public function storeBarang(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'      => 'required|string|max:100',
            'jenis'     => 'required|in:S,F,P',
            'kuantitas' => 'required|string|max:20',
            'idsatuan'  => 'required|integer',
            'harga'     => 'required|integer',
            'status'    => 'required|integer'
        ]);

        // Eksekusi Insert menggunakan Raw SQL
        DB::insert('INSERT INTO barang (nama, jenis, kuantitas, idsatuan, harga, status) VALUES (?, ?, ?, ?, ?, ?)', [
            $request->nama,
            $request->jenis,
            $request->kuantitas,
            $request->idsatuan,
            $request->harga,
            $request->status
        ]);

        return redirect('/admin/barang')->with('success', 'Barang baru berhasil ditambahkan!');
    }
    // ==========================================

    public function indexRole()
    {
        $roles = DB::select('SELECT * FROM view_role');
        return view('admin.role.index', compact('roles'));
    }

    public function indexUser()
    {
        $users = DB::select('SELECT * FROM view_user');
        return view('admin.user.index', compact('users'));
    }

    public function indexSatuan()
    {
        $satuans = DB::select('SELECT * FROM view_satuan');
        return view('admin.satuan.index', compact('satuans'));
    }

    public function indexVendor()
    {
        $vendors = DB::select('SELECT * FROM view_vendor');
        return view('admin.vendor.index', compact('vendors'));
    }

    public function indexMargin()
    {
        $margins = DB::select('SELECT * FROM view_margin_penjualan');
        return view('admin.margin.index', compact('margins'));
    }
}
