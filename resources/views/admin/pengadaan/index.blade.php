<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pengadaan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">

        <!-- 1. Bagian judul + tombol buat pengadaan baru -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Transaksi Pengadaan (SIMATERIAL)</h1>
            <a href="/admin/pengadaan/create"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                + Buat Pengadaan Baru
            </a>
        </div>

        <!-- 2. Notifikasi sukses setelah memanggil sp_buat_pengadaan -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- 2b. Notifikasi error (misal gagal hapus) -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID</th>
                    <th class="border border-gray-300 p-3">Timestamp</th>
                    <th class="border border-gray-300 p-3">Purchasing User</th>
                    <th class="border border-gray-300 p-3">Vendor</th>
                    <th class="border border-gray-300 p-3">Nama Barang (Qty)</th>
                    <th class="border border-gray-300 p-3">Subtotal</th>
                    <th class="border border-gray-300 p-3">PPN</th>
                    <th class="border border-gray-300 p-3">Total Nilai</th>
                    <th class="border border-gray-300 p-3">Status</th>
                    <!-- 3a. Kolom Aksi di header tabel -->
                    <th class="border border-gray-300 p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengadaans as $item)
                @php
                    $daftarBarang = $namaBarangPerPengadaan[$item->idpengadaan] ?? [];
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idpengadaan }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->timestamp }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->username }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->nama_vendor }}</td>
                    <td class="border border-gray-300 p-3">
                        {{ !empty($daftarBarang) ? implode(', ', $daftarBarang) : '-' }}
                    </td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->subtotal_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3 font-bold text-blue-600">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm {{ $item->status == 'S' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $item->status == 'S' ? 'Selesai' : 'Dipesan' }}
                        </span>
                    </td>
                    <!-- 3b. Tombol Hapus di setiap baris -->
                    <td class="border border-gray-300 p-3">
                        <form action="/admin/pengadaan/{{ $item->idpengadaan }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan pengadaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm font-semibold">
                                Batalkan
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
