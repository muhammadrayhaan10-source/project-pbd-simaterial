<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold text-gray-800 mb-4">Edit Data Barang</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/barang/{{ $barang->idbarang }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Barang</label>
                <input type="text" name="nama" value="{{ old('nama', $barang->nama) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Jenis</label>
                <select name="jenis" required class="w-full border rounded p-2">
                    <option value="S" {{ old('jenis', $barang->jenis) == 'S' ? 'selected' : '' }}>S</option>
                    <option value="F" {{ old('jenis', $barang->jenis) == 'F' ? 'selected' : '' }}>F</option>
                    <option value="P" {{ old('jenis', $barang->jenis) == 'P' ? 'selected' : '' }}>P</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Kuantitas</label>
                <input type="text" name="kuantitas" value="{{ old('kuantitas', $barang->kuantitas) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Satuan</label>
                <select name="idsatuan" required class="w-full border rounded p-2">
                    @foreach($satuans as $satuan)
                        <option value="{{ $satuan->idsatuan }}" {{ old('idsatuan', $barang->idsatuan) == $satuan->idsatuan ? 'selected' : '' }}>
                            {{ $satuan->jenis_satuan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $barang->harga) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Status</label>
                <select name="status" required class="w-full border rounded p-2">
                    <option value="1" {{ old('status', $barang->status) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $barang->status) == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">Simpan Perubahan</button>
                <a href="/admin/barang" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
