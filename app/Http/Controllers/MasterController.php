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

    public function destroyBarang($id)
{
    try {
        DB::delete('DELETE FROM barang WHERE idbarang = ?', [$id]);
        return redirect('/admin/barang')->with('success', 'Barang berhasil dihapus!');
    } catch (\Illuminate\Database\QueryException $e) {
        // Biasanya gagal jika barang sudah dipakai di transaksi/kartu stok (foreign key)
        return redirect('/admin/barang')->withErrors([
            'error' => 'Barang tidak bisa dihapus karena masih digunakan pada riwayat transaksi atau stok.'
        ]);
    }
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

    public function createUser()
{
    $roles = DB::select('SELECT * FROM role');
    return view('admin.user.create', compact('roles'));
}

public function storeUser(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:50',
        'password' => 'required|string|min:4',
        'idrole'   => 'required|integer'
    ]);

    DB::insert('INSERT INTO user (username, password, idrole) VALUES (?, SHA2(?, 256), ?)', [
        $request->username,
        $request->password,
        $request->idrole
    ]);

    return redirect('/admin/user')->with('success', 'User baru berhasil ditambahkan!');
}

public function destroyUser($id)
{
    try {
        DB::delete('DELETE FROM user WHERE iduser = ?', [$id]);
        return redirect('/admin/user')->with('success', 'User berhasil dihapus!');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/admin/user')->withErrors([
            'error' => 'User tidak bisa dihapus karena masih terhubung dengan data transaksi atau margin.'
        ]);
    }
}

    public function indexSatuan()
    {
        $satuans = DB::select('SELECT * FROM view_satuan');
        return view('admin.satuan.index', compact('satuans'));
    }

    public function createSatuan()
    {
        return view('admin.satuan.create');
    }

    public function destroySatuan($id)
{
    try {
        DB::delete('DELETE FROM satuan WHERE idsatuan = ?', [$id]);
        return redirect('/admin/satuan')->with('success', 'Satuan berhasil dihapus!');
    } catch (\Illuminate\Database\QueryException $e) {
        // Biasanya gagal jika satuan sudah dipakai di tabel barang (foreign key)
        return redirect('/admin/satuan')->withErrors([
            'error' => 'Satuan tidak bisa dihapus karena masih digunakan pada data barang.'
        ]);
    }
}
    public function storeSatuan(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_satuan'   => 'required|string|max:45',
            'status' => 'required|integer|in:0,1'
        ]);

        // Eksekusi Insert menggunakan Raw SQL
        DB::insert('INSERT INTO satuan (jenis_satuan, status) VALUES (?, ?)', [
            $request->jenis_satuan,
            $request->status
        ]);

        return redirect('/admin/satuan')->with('success', 'Satuan baru berhasil ditambahkan!');
    }

    public function indexVendor()
    {
        $vendors = DB::select('SELECT * FROM view_vendor');
        return view('admin.vendor.index', compact('vendors'));
    }

    public function createVendor()
{
    return view('admin.vendor.create');
}

public function storeVendor(Request $request)
{
    $request->validate([
        'nama_vendor' => 'required|string|max:100',
        'badan_hukum' => 'required|in:P,C,U',
        'status'      => 'required|in:A,N'
    ]);

    DB::insert('INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, ?)', [
        $request->nama_vendor,
        $request->badan_hukum,
        $request->status
    ]);

    return redirect('/admin/vendor')->with('success', 'Vendor berhasil ditambahkan!');
}

public function destroyVendor($id)
{
    try {
        DB::delete('DELETE FROM vendor WHERE idvendor = ?', [$id]);
        return redirect('/admin/vendor')->with('success', 'Vendor berhasil dihapus!');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/admin/vendor')->withErrors([
            'error' => 'Vendor tidak bisa dihapus karena masih digunakan pada transaksi pengadaan.'
        ]);
    }
}

    public function indexMargin()
    {
        $margins = DB::select('SELECT * FROM view_margin_penjualan');
        return view('admin.margin.index', compact('margins'));
    }

    public function createMargin()
{
    return view('admin.margin.create');
}

public function storeMargin(Request $request)
{
    $request->validate([
        'persen' => 'required|numeric|min:0',
        'status' => 'required|integer|in:0,1'
    ]);

    $iduser = session('iduser', 1);

    DB::insert('INSERT INTO margin_penjualan (persen, status, iduser, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
        $request->persen,
        $request->status,
        $iduser
    ]);

    return redirect('/admin/margin')->with('success', 'Margin penjualan berhasil ditambahkan!');
}

public function destroyMargin($id)
{
    try {
        DB::delete('DELETE FROM margin_penjualan WHERE idmargin_penjualan = ?', [$id]);
        return redirect('/admin/margin')->with('success', 'Margin penjualan berhasil dihapus!');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/admin/margin')->withErrors([
            'error' => 'Margin tidak bisa dihapus karena masih digunakan pada transaksi penjualan.'
        ]);
    }
}

}
