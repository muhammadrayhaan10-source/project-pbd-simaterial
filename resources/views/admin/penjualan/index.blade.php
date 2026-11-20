<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Transaksi Penjualan / POS (SIMATERIAL)</h1>
            <a href="/admin/penjualan/create"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                + Buat Penjualan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel 1: Header Penjualan (view_penjualan) -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID Penjualan</th>
                    <th class="border border-gray-300 p-3">Kasir</th>
                    <th class="border border-gray-300 p-3">Subtotal</th>
                    <th class="border border-gray-300 p-3">PPN (11%)</th>
                    <th class="border border-gray-300 p-3">Total Nilai</th>
                    <th class="border border-gray-300 p-3">Waktu Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idpenjualan }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->username }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->subtotal_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3 font-bold text-green-600">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabel 2: Detail Barang Terjual (LETakkan tepat di bawah </table> tabel pertama) -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Detail Barang Terjual</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="border border-gray-300 p-3">ID Detail</th>
                        <th class="border border-gray-300 p-3">ID Penjualan</th>
                        <th class="border border-gray-300 p-3">Nama Barang</th>
                        <th class="border border-gray-300 p-3">Jumlah</th>
                        <th class="border border-gray-300 p-3">Harga Satuan</th>
                        <th class="border border-gray-300 p-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detailPenjualans as $detail)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-3">{{ $detail->iddetail_penjualan }}</td>
                        <td class="border border-gray-300 p-3 font-semibold">#{{ $detail->penjualan_idpenjualan }}</td>
                        <td class="border border-gray-300 p-3 font-semibold">{{ $detail->nama_barang }}</td>
                        <td class="border border-gray-300 p-3">{{ $detail->jumlah }}</td>
                        <td class="border border-gray-300 p-3">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 p-3 font-bold text-blue-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border border-gray-300 p-3 text-center text-gray-500">
                            Belum ada data detail penjualan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
