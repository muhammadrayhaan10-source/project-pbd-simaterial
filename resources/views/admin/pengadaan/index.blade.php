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
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Transaksi Pengadaan (SIMATERIAL)</h1>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID</th>
                    <th class="border border-gray-300 p-3">Timestamp</th>
                    <th class="border border-gray-300 p-3">Purchasing User</th>
                    <th class="border border-gray-300 p-3">Vendor</th>
                    <th class="border border-gray-300 p-3">Subtotal</th>
                    <th class="border border-gray-300 p-3">PPN</th>
                    <th class="border border-gray-300 p-3">Total Nilai</th>
                    <th class="border border-gray-300 p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengadaans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idpengadaan }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->timestamp }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->username }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->nama_vendor }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->subtotal_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3 font-bold text-blue-600">Rp {{ number_format($item->total_nilai, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm {{ $item->status == 'S' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $item->status == 'S' ? 'Selesai' : 'Dipesan' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
