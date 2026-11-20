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

    // Form tambah transaksi pengadaan
public function createPengadaan()
{
    $vendors = DB::select('SELECT * FROM view_vendor');
    $barangs = DB::select('SELECT * FROM view_barang');

    return view('admin.pengadaan.create', compact('vendors', 'barangs'));
}

// Menyimpan transaksi pengadaan menggunakan Stored Procedure sp_buat_pengadaan
public function storePengadaan(Request $request)
{
    $request->validate([
        'idvendor' => 'required|integer',
        'idbarang' => 'required|integer',
        'jumlah'   => 'required|integer|min:1',
        'harga'    => 'required|integer|min:1',
    ]);

    // Ambil iduser dari session (default 1 jika belum login/set session)
    $iduser = session('iduser', 1);

    try {
        DB::statement('CALL sp_buat_pengadaan(?, ?, ?, ?, ?, @idpengadaan)', [
            $iduser,
            $request->idvendor,
            $request->idbarang,
            $request->jumlah,
            $request->harga,
        ]);

        $hasil = DB::select('SELECT @idpengadaan AS idpengadaan');
        $idBaru = $hasil[0]->idpengadaan ?? null;

        $pesan = $idBaru
            ? "Transaksi pengadaan berhasil dibuat (ID: {$idBaru})!"
            : "Transaksi pengadaan berhasil dibuat!";

        return redirect('/admin/pengadaan')->with('success', $pesan);
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()->withInput()->withErrors([
            'error' => 'Gagal membuat pengadaan: ' . $e->getMessage()
        ]);
    }
}

// Menghapus data transaksi pengadaan menggunakan Raw SQL
public function destroyPengadaan($id)
{
    try {
        // Cek apakah pengadaan sudah pernah masuk ke penerimaan
        $sudahDiterima = DB::select('SELECT idpenerimaan FROM penerimaan WHERE idpengadaan = ? LIMIT 1', [$id]);
        if (!empty($sudahDiterima)) {
            return redirect('/admin/pengadaan')->withErrors([
                'error' => 'Pengadaan tidak bisa dihapus karena sudah masuk ke penerimaan.'
            ]);
        }

        // Hapus detail pengadaan terlebih dahulu (sesuaikan nama kolom jika berbeda, misal pengadaan_idpengadaan)
        DB::delete('DELETE FROM detail_pengadaan WHERE idpengadaan = ?', [$id]);

        // Baru hapus header pengadaan
        DB::delete('DELETE FROM pengadaan WHERE idpengadaan = ?', [$id]);

        return redirect('/admin/pengadaan')->with('success', 'Data pengadaan berhasil dihapus!');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/admin/pengadaan')->withErrors([
            'error' => 'Pengadaan tidak bisa dihapus karena masih terhubung dengan data lain: ' . $e->getMessage()
        ]);
    }
}

    // Menampilkan data penerimaan menggunakan MySQL View
    public function indexPenerimaan()
    {
        $penerimaans = DB::select('SELECT * FROM view_penerimaan');
        return view('admin.penerimaan.index', compact('penerimaans'));
    }
   // Menampilkan data penjualan & detail barang menggunakan MySQL View + Raw SQL
    public function indexPenjualan()
    {
        $penjualans = DB::select('SELECT * FROM view_penjualan');

        $detailPenjualans = DB::select('
            SELECT
                dp.iddetail_penjualan,
                dp.penjualan_idpenjualan,
                dp.idbarang,
                b.nama AS nama_barang,
                dp.jumlah,
                dp.harga_satuan,
                dp.subtotal
            FROM detail_penjualan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            ORDER BY dp.penjualan_idpenjualan DESC, dp.iddetail_penjualan ASC
        ');

        return view('admin.penjualan.index', compact('penjualans', 'detailPenjualans'));
    }

    // Form tambah transaksi penjualan
public function createPenjualan()
{
    $barangs = DB::select('SELECT * FROM view_barang');

    return view('admin.penjualan.create', compact('barangs'));
}

// Menyimpan transaksi penjualan menggunakan Stored Procedure sp_buat_penjualan
public function storePenjualan(Request $request)
{
    $request->validate([
        'idbarang' => 'required|integer',
        'jumlah'   => 'required|integer|min:1',
    ]);

    $iduser = session('iduser', 1);

    try {
        DB::statement('CALL sp_buat_penjualan(?, ?, ?, @idpenjualan)', [
            $iduser,
            $request->idbarang,
            $request->jumlah,
        ]);

        $hasil = DB::select('SELECT @idpenjualan AS idpenjualan');
        $idBaru = $hasil[0]->idpenjualan ?? null;

        $pesan = $idBaru
            ? "Transaksi penjualan berhasil dibuat (ID Penjualan: {$idBaru})!"
            : "Transaksi penjualan berhasil dibuat!";

        return redirect('/admin/penjualan')->with('success', $pesan);
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()->withInput()->withErrors([
            'error' => 'Gagal memproses penjualan: ' . $e->getMessage()
        ]);
    }
}

    // Form tambah transaksi penerimaan barang
public function createPenerimaan()
{
    // Mengambil daftar pengadaan menggunakan view/raw SQL
    // Jika ingin membatasi yang belum selesai saja, sesuaikan WHERE-nya (misal status != 'S')
    $pengadaans = DB::select('SELECT * FROM view_pengadaan');

    return view('admin.penerimaan.create', compact('pengadaans'));
}

// Menyimpan transaksi penerimaan menggunakan Stored Procedure sp_terima_pengadaan
public function storePenerimaan(Request $request)
{
    $request->validate([
        'idpengadaan' => 'required|integer',
    ]);

    $iduser = session('iduser', 1);

    try {
        DB::statement('CALL sp_terima_pengadaan(?, ?, @idpenerimaan)', [
            $request->idpengadaan,
            $iduser,
        ]);

        $hasil = DB::select('SELECT @idpenerimaan AS idpenerimaan');
        $idBaru = $hasil[0]->idpenerimaan ?? null;

        $pesan = $idBaru
            ? "Penerimaan barang berhasil diproses (ID Penerimaan: {$idBaru})!"
            : "Penerimaan barang berhasil diproses!";

        return redirect('/admin/penerimaan')->with('success', $pesan);
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->back()->withInput()->withErrors([
            'error' => 'Gagal memproses penerimaan: ' . $e->getMessage()
        ]);
    }
}
}
