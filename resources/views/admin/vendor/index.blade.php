<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Vendor - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Vendor / Supplier (SIMATERIAL)</h1>
            <a href="/admin/vendor/create"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                + Tambah Vendor Baru
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
                    <th class="border border-gray-300 p-3">ID</th>
                    <th class="border border-gray-300 p-3">Nama Vendor</th>
                    <th class="border border-gray-300 p-3">Badan Hukum</th>
                    <th class="border border-gray-300 p-3">Status</th>
                    <th class="border border-gray-300 p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendors as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idvendor }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->nama_vendor }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->badan_hukum }}</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm {{ $item->status_vendor == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status_vendor }}
                        </span>
                    </td>
                    <td class="border border-gray-300 p-3">
                        <div class="flex items-center gap-2">
                            <a href="/admin/vendor/{{ $item->idvendor }}/edit"
                                class="bg-amber-500 text-white px-3 py-1 rounded hover:bg-amber-600 text-sm font-semibold">
                                Edit
                            </a>
                            <form action="/admin/vendor/{{ $item->idvendor }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus vendor ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
