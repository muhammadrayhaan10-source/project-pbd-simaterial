<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Satuan - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">

        <!-- Bagian judul + tombol tambah satuan baru -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Satuan Barang (SIMATERIAL)</h1>
            <a href="/admin/satuan/create"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                + Tambah Satuan Baru
            </a>
        </div>

        <!-- Pesan notifikasi jika berhasil simpan/hapus satuan -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tampilkan pesan error jika gagal hapus (misalnya masih dipakai barang) -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID Satuan</th>
                    <th class="border border-gray-300 p-3">Jenis Satuan</th>
                    <th class="border border-gray-300 p-3">Status</th>
                    <th class="border border-gray-300 p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($satuans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->idsatuan }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->jenis_satuan }}</td>
                    <td class="border border-gray-300 p-3">
                        <span class="px-2 py-1 rounded text-sm {{ $item->status_satuan == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->status_satuan }}
                        </span>
                    </td>
                    <td class="border border-gray-300 p-3">
                        <form action="/admin/satuan/{{ $item->idsatuan }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus satuan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm font-semibold">
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
