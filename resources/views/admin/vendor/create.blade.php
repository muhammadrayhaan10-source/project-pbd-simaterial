<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Vendor - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Vendor Baru</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/vendor" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Vendor</label>
                <input type="text" name="nama_vendor" value="{{ old('nama_vendor') }}" required
                    class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Contoh: PT Semen Nusantara">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Badan Hukum</label>
                <select name="badan_hukum" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="P" {{ old('badan_hukum') == 'P' ? 'selected' : '' }}>PT</option>
                    <option value="C" {{ old('badan_hukum') == 'C' ? 'selected' : '' }}>CV</option>
                    <option value="U" {{ old('badan_hukum') == 'U' ? 'selected' : '' }}>UD</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="A" {{ old('status', 'A') == 'A' ? 'selected' : '' }}>Aktif</option>
                    <option value="N" {{ old('status') == 'N' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="/admin/vendor" class="text-gray-600 hover:underline">← Batal & Kembali</a>
                <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700">
                    Simpan Vendor
                </button>
            </div>
        </form>
    </div>
</body>
</html>
