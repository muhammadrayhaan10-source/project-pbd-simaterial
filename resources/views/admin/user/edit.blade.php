<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - SIMATERIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold text-gray-800 mb-4">Edit Data User</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/user/{{ $user->iduser }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Role</label>
                <select name="idrole" required class="w-full border rounded p-2">
                    @foreach($roles as $role)
                        <option value="{{ $role->idrole }}" {{ old('idrole', $user->idrole) == $role->idrole ? 'selected' : '' }}>
                            {{ $role->nama_role }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full border rounded p-2">
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">Simpan Perubahan</button>
                <a href="/admin/user" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
