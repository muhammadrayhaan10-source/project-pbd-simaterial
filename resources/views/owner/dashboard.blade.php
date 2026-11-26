<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-slate-800 text-white px-6 py-4 flex items-center justify-between shadow">
        <div>
            <span class="font-bold text-lg">SIMATERIAL — Dashboard Owner</span>
            <span class="ml-3 text-sm bg-slate-700 px-3 py-1 rounded-full">
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

    <div class="max-w-6xl mx-auto p-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-xs text-gray-500">Total Barang</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBarang }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-xs text-gray-500">Total Pengadaan</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPengadaan }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-xs text-gray-500">Total Penerimaan</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPenerimaan }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-xs text-gray-500">Total Penjualan</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPenjualan }}</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="font-bold text-gray-800 mb-4">Menu Monitoring &amp; Data</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <a href="/admin/pengadaan" class="p-4 border rounded hover:bg-slate-50 font-semibold text-slate-800">Laporan / Data Pengadaan</a>
                <a href="/admin/penerimaan" class="p-4 border rounded hover:bg-slate-50 font-semibold text-slate-800">Laporan / Data Penerimaan</a>
                <a href="/admin/penjualan" class="p-4 border rounded hover:bg-slate-50 font-semibold text-slate-800">Laporan / Data Penjualan</a>
                <a href="/admin/barang" class="p-4 border rounded hover:bg-slate-50 font-medium text-slate-700">Data Barang</a>
                <a href="/admin/vendor" class="p-4 border rounded hover:bg-slate-50 font-medium text-slate-700">Data Vendor</a>
                <a href="/admin/margin" class="p-4 border rounded hover:bg-slate-50 font-medium text-slate-700">Margin Penjualan</a>
            </div>
        </div>
    </div>
</body>
</html>
