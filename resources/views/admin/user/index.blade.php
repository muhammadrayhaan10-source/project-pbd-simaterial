<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Pengguna Sistem (SIMATERIAL)</h1>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 p-3">ID User</th>
                    <th class="border border-gray-300 p-3">Username</th>
                    <th class="border border-gray-300 p-3">Role / Hak Akses</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-3">{{ $item->iduser }}</td>
                    <td class="border border-gray-300 p-3 font-semibold">{{ $item->username }}</td>
                    <td class="border border-gray-300 p-3">{{ $item->nama_role }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
