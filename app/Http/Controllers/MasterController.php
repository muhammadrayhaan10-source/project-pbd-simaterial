<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    // =========================================================================
    // 1. MASTER DATA BARANG
    // =========================================================================

    public function indexBarang()
    {
        $barangs = DB::select('SELECT * FROM view_barang');

        return view('admin.barang.index', compact('barangs'));
    }

    public function createBarang()
    {
        $satuans = DB::select('SELECT * FROM satuan WHERE status = 1');

        return view('admin.barang.create', compact('satuans'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'jenis'     => 'required|in:S,F,P',
            'kuantitas' => 'required|string|max:20',
            'idsatuan'  => 'required|integer',
            'harga'     => 'required|integer',
            'status'    => 'required|integer',
        ]);

        DB::insert(
            'INSERT INTO barang (nama, jenis, kuantitas, idsatuan, harga, status) VALUES (?, ?, ?, ?, ?, ?)',
            [
                $request->nama,
                $request->jenis,
                $request->kuantitas,
                $request->idsatuan,
                $request->harga,
                $request->status,
            ]
        );

        return redirect('/admin/barang')->with('success', 'Barang baru berhasil ditambahkan!');
    }

    // --- BARANG (di bawah storeBarang) ---
    public function editBarang($id)
    {
        $barangs = DB::select('SELECT * FROM barang WHERE idbarang = ? LIMIT 1', [$id]);
        if (empty($barangs)) {
            return redirect('/admin/barang')->withErrors(['error' => 'Data barang tidak ditemukan.']);
        }
        $barang  = $barangs[0];
        $satuans = DB::select('SELECT * FROM satuan WHERE status = 1');

        return view('admin.barang.edit', compact('barang', 'satuans'));
    }

    public function updateBarang(Request $request, $id)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'jenis'     => 'required|in:S,F,P',
            'kuantitas' => 'required|string|max:20',
            'idsatuan'  => 'required|integer',
            'harga'     => 'required|integer',
            'status'    => 'required|integer',
        ]);

        DB::update(
            'UPDATE barang SET nama = ?, jenis = ?, kuantitas = ?, idsatuan = ?, harga = ?, status = ? WHERE idbarang = ?',
            [
                $request->nama,
                $request->jenis,
                $request->kuantitas,
                $request->idsatuan,
                $request->harga,
                $request->status,
                $id,
            ]
        );

        return redirect('/admin/barang')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroyBarang($id)
    {
        try {
            DB::delete('DELETE FROM barang WHERE idbarang = ?', [$id]);

            return redirect('/admin/barang')->with('success', 'Barang berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/admin/barang')->withErrors([
                'error' => 'Barang tidak bisa dihapus karena masih digunakan pada riwayat transaksi atau stok.',
            ]);
        }
    }

    // =========================================================================
    // 2. MASTER DATA ROLE
    // =========================================================================

    public function indexRole()
    {
        $roles = DB::select('SELECT * FROM view_role');

        return view('admin.role.index', compact('roles'));
    }

    // =========================================================================
    // 3. MASTER DATA USER
    // =========================================================================

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
            'idrole'   => 'required|integer',
        ]);

        DB::insert(
            'INSERT INTO user (username, password, idrole) VALUES (?, SHA2(?, 256), ?)',
            [
                $request->username,
                $request->password,
                $request->idrole,
            ]
        );

        return redirect('/admin/user')->with('success', 'User baru berhasil ditambahkan!');
    }

    // --- USER (di bawah storeUser) ---
    public function editUser($id)
    {
        $users = DB::select('SELECT iduser, username, idrole FROM user WHERE iduser = ? LIMIT 1', [$id]);
        if (empty($users)) {
            return redirect('/admin/user')->withErrors(['error' => 'Data user tidak ditemukan.']);
        }
        $user  = $users[0];
        $roles = DB::select('SELECT * FROM role');

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'nullable|string|min:4',
            'idrole'   => 'required|integer',
        ]);

        if ($request->filled('password')) {
            DB::update(
                'UPDATE user SET username = ?, password = SHA2(?, 256), idrole = ? WHERE iduser = ?',
                [$request->username, $request->password, $request->idrole, $id]
            );
        } else {
            DB::update(
                'UPDATE user SET username = ?, idrole = ? WHERE iduser = ?',
                [$request->username, $request->idrole, $id]
            );
        }

        return redirect('/admin/user')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        try {
            DB::delete('DELETE FROM user WHERE iduser = ?', [$id]);

            return redirect('/admin/user')->with('success', 'User berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/admin/user')->withErrors([
                'error' => 'User tidak bisa dihapus karena masih terhubung dengan data transaksi atau margin.',
            ]);
        }
    }

    // =========================================================================
    // 4. MASTER DATA SATUAN
    // =========================================================================

    public function indexSatuan()
    {
        $satuans = DB::select('SELECT * FROM view_satuan');

        return view('admin.satuan.index', compact('satuans'));
    }

    public function createSatuan()
    {
        return view('admin.satuan.create');
    }

    public function storeSatuan(Request $request)
    {
        $request->validate([
            'jenis_satuan' => 'required|string|max:45',
            'status'       => 'required|integer|in:0,1',
        ]);

        DB::insert(
            'INSERT INTO satuan (jenis_satuan, status) VALUES (?, ?)',
            [
                $request->jenis_satuan,
                $request->status,
            ]
        );

        return redirect('/admin/satuan')->with('success', 'Satuan baru berhasil ditambahkan!');
    }

    // --- SATUAN (di bawah storeSatuan) ---
    public function editSatuan($id)
    {
        $satuans = DB::select('SELECT * FROM satuan WHERE idsatuan = ? LIMIT 1', [$id]);
        if (empty($satuans)) {
            return redirect('/admin/satuan')->withErrors(['error' => 'Data satuan tidak ditemukan.']);
        }
        $satuan = $satuans[0];

        return view('admin.satuan.edit', compact('satuan'));
    }

    public function updateSatuan(Request $request, $id)
    {
        $request->validate([
            'jenis_satuan' => 'required|string|max:45',
            'status'       => 'required|integer|in:0,1',
        ]);

        DB::update(
            'UPDATE satuan SET jenis_satuan = ?, status = ? WHERE idsatuan = ?',
            [$request->jenis_satuan, $request->status, $id]
        );

        return redirect('/admin/satuan')->with('success', 'Data satuan berhasil diperbarui!');
    }

    public function destroySatuan($id)
    {
        try {
            DB::delete('DELETE FROM satuan WHERE idsatuan = ?', [$id]);

            return redirect('/admin/satuan')->with('success', 'Satuan berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/admin/satuan')->withErrors([
                'error' => 'Satuan tidak bisa dihapus karena masih digunakan pada data barang.',
            ]);
        }
    }

    // =========================================================================
    // 5. MASTER DATA VENDOR
    // =========================================================================

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
            'status'      => 'required|in:A,N',
        ]);

        DB::insert(
            'INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES (?, ?, ?)',
            [
                $request->nama_vendor,
                $request->badan_hukum,
                $request->status,
            ]
        );

        return redirect('/admin/vendor')->with('success', 'Vendor berhasil ditambahkan!');
    }

    // --- VENDOR (di bawah storeVendor) ---
    public function editVendor($id)
    {
        $vendors = DB::select('SELECT * FROM vendor WHERE idvendor = ? LIMIT 1', [$id]);
        if (empty($vendors)) {
            return redirect('/admin/vendor')->withErrors(['error' => 'Data vendor tidak ditemukan.']);
        }
        $vendor = $vendors[0];

        return view('admin.vendor.edit', compact('vendor'));
    }

    public function updateVendor(Request $request, $id)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100',
            'badan_hukum' => 'required|in:P,C,U',
            'status'      => 'required|in:A,N',
        ]);

        DB::update(
            'UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status = ? WHERE idvendor = ?',
            [$request->nama_vendor, $request->badan_hukum, $request->status, $id]
        );

        return redirect('/admin/vendor')->with('success', 'Data vendor berhasil diperbarui!');
    }

    public function destroyVendor($id)
    {
        try {
            DB::delete('DELETE FROM vendor WHERE idvendor = ?', [$id]);

            return redirect('/admin/vendor')->with('success', 'Vendor berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/admin/vendor')->withErrors([
                'error' => 'Vendor tidak bisa dihapus karena masih digunakan pada transaksi pengadaan.',
            ]);
        }
    }

    // =========================================================================
    // 6. MASTER DATA MARGIN PENJUALAN
    // =========================================================================

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
            'status' => 'required|integer|in:0,1',
        ]);

        $iduser = session('iduser', 1);

        DB::insert(
            'INSERT INTO margin_penjualan (persen, status, iduser, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())',
            [
                $request->persen,
                $request->status,
                $iduser,
            ]
        );

        return redirect('/admin/margin')->with('success', 'Margin penjualan berhasil ditambahkan!');
    }

    // --- MARGIN PENJUALAN (di bawah storeMargin) ---
    public function editMargin($id)
    {
        $margins = DB::select('SELECT * FROM margin_penjualan WHERE idmargin_penjualan = ? LIMIT 1', [$id]);
        if (empty($margins)) {
            return redirect('/admin/margin')->withErrors(['error' => 'Data margin tidak ditemukan.']);
        }
        $margin = $margins[0];

        return view('admin.margin.edit', compact('margin'));
    }

    public function updateMargin(Request $request, $id)
    {
        $request->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1',
        ]);

        $iduser = session('iduser', 1);

        // Jika margin ini diaktifkan (status = 1), nonaktifkan margin lain agar hanya 1 yang aktif
        if ((int) $request->status === 1) {
            DB::update('UPDATE margin_penjualan SET status = 0, updated_at = NOW() WHERE idmargin_penjualan != ?', [$id]);
        }

        DB::update(
            'UPDATE margin_penjualan SET persen = ?, status = ?, iduser = ?, updated_at = NOW() WHERE idmargin_penjualan = ?',
            [$request->persen, $request->status, $iduser, $id]
        );

        return redirect('/admin/margin')->with('success', 'Margin penjualan berhasil diperbarui!');
    }

    public function destroyMargin($id)
    {
        try {
            DB::delete('DELETE FROM margin_penjualan WHERE idmargin_penjualan = ?', [$id]);

            return redirect('/admin/margin')->with('success', 'Margin penjualan berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/admin/margin')->withErrors([
                'error' => 'Margin tidak bisa dihapus karena masih digunakan pada transaksi penjualan.',
            ]);
        }
    }
}
