<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengadaan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-indigo-700 text-white px-6 py-4 flex items-center justify-between shadow">
        <div>
            <span class="font-bold text-lg">SIMATERIAL — Dashboard Pengadaan</span>
            <span class="ml-3 text-sm bg-indigo-800 px-3 py-1 rounded-full">
                {{ $username }} ({{ $namaRole }})
            </span>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded">
                Logout
            </button>
        </form>
    </nav>

    <div class="max-w-5xl mx-auto p-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow">
            <h2 class="font-bold text-gray-800 mb-4">Fitur Pengadaan &amp; Stok</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <a href="/admin/pengadaan" class="p-4 border rounded hover:bg-indigo-50 font-semibold text-indigo-700">Transaksi Pengadaan</a>
                <a href="/admin/penerimaan" class="p-4 border rounded hover:bg-indigo-50 font-medium text-indigo-700">Transaksi Penerimaan</a>
                <a href="/admin/vendor" class="p-4 border rounded hover:bg-indigo-50 font-medium text-indigo-700">Data Vendor</a>
                <a href="/admin/barang" class="p-4 border rounded hover:bg-indigo-50 font-medium text-indigo-700">Data Barang</a>
            </div>
        </div>
    </div>
</body>
</html>
