<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // =========================================================================
    // 1. TRANSAKSI PENGADAAN
    // =========================================================================

    public function indexPengadaan()
    {
        $pengadaans = DB::select('SELECT * FROM view_pengadaan ORDER BY idpengadaan DESC');

        $rowsDetail = DB::select('
            SELECT
                dp.idpengadaan,
                b.nama AS nama_barang,
                dp.jumlah
            FROM detail_pengadaan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            ORDER BY dp.idpengadaan DESC
        ');

        $namaBarangPerPengadaan = [];
        foreach ($rowsDetail as $row) {
            $namaBarangPerPengadaan[$row->idpengadaan][] = $row->nama_barang . ' (' . $row->jumlah . ')';
        }

        return view('admin.pengadaan.index', compact('pengadaans', 'namaBarangPerPengadaan'));
    }

    public function createPengadaan()
    {
        $vendors = DB::select('SELECT * FROM view_vendor');
        $barangs = DB::select('SELECT * FROM view_barang');

        return view('admin.pengadaan.create', compact('vendors', 'barangs'));
    }

    public function storePengadaan(Request $request)
    {
        $request->validate([
            'idvendor' => 'required|integer',
            'idbarang' => 'required|integer',
            'jumlah'   => 'required|integer|min:1',
            'harga'    => 'required|integer|min:1',
        ]);

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
                : 'Transaksi pengadaan berhasil dibuat!';

            return redirect('/admin/pengadaan')->with('success', $pesan);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal membuat pengadaan: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroyPengadaan($id)
    {
        try {
            $sudahDiterima = DB::select('SELECT idpenerimaan FROM penerimaan WHERE idpengadaan = ? LIMIT 1', [$id]);
            if (!empty($sudahDiterima)) {
                return redirect('/admin/pengadaan')->withErrors([
                    'error' => 'Pengadaan tidak bisa dihapus karena sudah masuk ke penerimaan.',
                ]);
            }

            DB::delete('DELETE FROM detail_pengadaan WHERE idpengadaan = ?', [$id]);
            DB::delete('DELETE FROM pengadaan WHERE idpengadaan = ?', [$id]);

            return redirect('/admin/pengadaan')->with('success', 'Data pengadaan berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/admin/pengadaan')->withErrors([
                'error' => 'Pengadaan tidak bisa dihapus karena masih terhubung dengan data lain: ' . $e->getMessage(),
            ]);
        }
    }

    // =========================================================================
    // 2. TRANSAKSI PENERIMAAN
    // =========================================================================

    public function indexPenerimaan()
    {
        $penerimaans = DB::select('SELECT * FROM view_penerimaan');

        return view('admin.penerimaan.index', compact('penerimaans'));
    }

    public function createPenerimaan()
    {
        $pengadaans = DB::select('SELECT * FROM view_pengadaan');

        return view('admin.penerimaan.create', compact('pengadaans'));
    }

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
                : 'Penerimaan barang berhasil diproses!';

            return redirect('/admin/penerimaan')->with('success', $pesan);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal memproses penerimaan: ' . $e->getMessage(),
            ]);
        }
    }

    // =========================================================================
    // 3. TRANSAKSI PENJUALAN
    // =========================================================================

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

    public function createPenjualan()
    {
        $barangs = DB::select('SELECT * FROM view_barang');

        return view('admin.penjualan.create', compact('barangs'));
    }

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
                : 'Transaksi penjualan berhasil dibuat!';

            return redirect('/admin/penjualan')->with('success', $pesan);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Gagal memproses penjualan: ' . $e->getMessage(),
            ]);
        }
    }
}
