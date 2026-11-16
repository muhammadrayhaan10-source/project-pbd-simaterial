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
