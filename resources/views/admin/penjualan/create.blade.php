<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Penjualan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Buat Transaksi Penjualan Baru (sp_buat_penjualan)</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/penjualan" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Pilih Barang</label>
                <select name="idbarang" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->idbarang }}" {{ old('idbarang') == $b->idbarang ? 'selected' : '' }}>
                            {{ $b->nama_barang }} ({{ $b->jenis_satuan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jumlah Dijual</label>
                <input type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required
                    class="w-full border border-gray-300 rounded-lg p-2.5">
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="/admin/penjualan" class="text-gray-600 hover:underline">← Batal & Kembali</a>
                <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan Penjualan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
