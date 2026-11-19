<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Katalog Material Baru</h1>

        <form action="/admin/barang" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Barang</label>
                <input type="text" name="nama" required class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Contoh: Semen Gresik">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Jenis Material</label>
                <select name="jenis" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="S">Material Struktur (S)</option>
                    <option value="F">Finishing (F)</option>
                    <option value="P">Perlengkapan (P)</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kuantitas / Spesifikasi Fisik</label>
                <input type="text" name="kuantitas" required class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Contoh: 50kg atau 10mm">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Satuan</label>
                <select name="idsatuan" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="">-- Pilih Satuan --</option>
                    @foreach($satuans as $satuan)
                        <option value="{{ $satuan->idsatuan }}">{{ $satuan->jenis_satuan }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Harga Dasar (Rp)</label>
                <input type="number" name="harga" required class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Contoh: 60000">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status Barang</label>
                <select name="status" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="/admin/barang" class="text-gray-600 hover:underline">← Batal & Kembali</a>
                <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700">Simpan Barang</button>
            </div>
        </form>
    </div>
</body>
</html>
