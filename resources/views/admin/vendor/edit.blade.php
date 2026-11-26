<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vendor - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold text-gray-800 mb-4">Edit Data Vendor</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/vendor/{{ $vendor->idvendor }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Vendor</label>
                <input type="text" name="nama_vendor" value="{{ old('nama_vendor', $vendor->nama_vendor) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Badan Hukum</label>
                <select name="badan_hukum" required class="w-full border rounded p-2">
                    <option value="P" {{ old('badan_hukum', $vendor->badan_hukum) == 'P' ? 'selected' : '' }}>P</option>
                    <option value="C" {{ old('badan_hukum', $vendor->badan_hukum) == 'C' ? 'selected' : '' }}>C</option>
                    <option value="U" {{ old('badan_hukum', $vendor->badan_hukum) == 'U' ? 'selected' : '' }}>U</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Status</label>
                <select name="status" required class="w-full border rounded p-2">
                    <option value="A" {{ old('status', $vendor->status) == 'A' ? 'selected' : '' }}>Aktif (A)</option>
                    <option value="N" {{ old('status', $vendor->status) == 'N' ? 'selected' : '' }}>Nonaktif (N)</option>
                </select>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">Simpan Perubahan</button>
                <a href="/admin/vendor" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
