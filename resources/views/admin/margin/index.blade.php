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

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Margin Penjualan (SIMATERIAL)</h1>
            <a href="/admin/margin/create"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                + Tambah Margin Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID Margin</th>
                    <th class="border border-gray-300 p-3">Persen (%)</th>
                    <th class="border border-gray-300 p-3">Status</th>
                    <th class="border border-gray-300 p-3">Ditetapkan Oleh</th>
                    <th class="border border-gray-300 p-3">Dibuat Pada</th>
                    <th class="border border-gray-300 p-3">Aksi</th>
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
                    <td class="border border-gray-300 p-3">
                        <form action="/admin/margin/{{ $item->idmargin_penjualan }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus margin ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm font-semibold">
                                Hapus
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
