<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Margin Penjualan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Margin Penjualan (SIMATERIAL)</h1>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID Margin</th>
                    <th class="border border-gray-300 p-3">Persen (%)</th>
                    <th class="border border-gray-300 p-3">Status</th>
                    <th class="border border-gray-300 p-3">Ditetapkan Oleh</th>
                    <th class="border border-gray-300 p-3">Dibuat Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($margins as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idmargin_penjualan }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->persen }}%</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm {{ $item->status_margin == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status_margin }}
                        </span>
                    </td>
                    <td class="border border-gray-300 p-3">{{ $item->ditetapkan_oleh }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
