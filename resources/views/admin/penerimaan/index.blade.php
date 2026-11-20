<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penerimaan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">

        <!-- 1. Judul + tombol Terima Pengadaan Baru -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Transaksi Penerimaan Barang (SIMATERIAL)</h1>
            <a href="/admin/penerimaan/create"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                + Terima Pengadaan Baru
            </a>
        </div>

        <!-- 2. Notifikasi sukses setelah memanggil sp_terima_pengadaan -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID Penerimaan</th>
                    <th class="border border-gray-300 p-3">ID Pengadaan</th>
                    <th class="border border-gray-300 p-3">Petugas Gudang</th>
                    <th class="border border-gray-300 p-3">Total Pengadaan</th>
                    <th class="border border-gray-300 p-3">Tanggal Dibuat</th>
                    <th class="border border-gray-300 p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penerimaans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idpenerimaan }}</td>
                    <td class="border border-gray-300 p-3">#{{ $item->idpengadaan }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->username }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->created_at }}</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">
                            {{ $item->status == 'S' ? 'Selesai' : $item->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
