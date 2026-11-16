<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - SIMATERIAL</title>
    <!-- Menggunakan Tailwind CSS untuk styling cepat -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Katalog Material (SIMATERIAL)</h1>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID</th>
                    <th class="border border-gray-300 p-3">Nama Barang</th>
                    <th class="border border-gray-300 p-3">Jenis</th>
                    <th class="border border-gray-300 p-3">Kuantitas</th>
                    <th class="border border-gray-300 p-3">Satuan</th>
                    <th class="border border-gray-300 p-3">Harga Dasar</th>
                    <th class="border border-gray-300 p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idbarang }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->nama_barang }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->jenis_barang }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->kuantitas }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->jenis_satuan }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm {{ $item->status_barang == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status_barang }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
