<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-gray-50">
    <div class="w-full max-w-lg bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Edit Profil</h1>

        @if(session('status'))
            <div class="mb-4 text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('marketing.profile.update') }}">
            @csrf
            @method('PATCH')

            <label class="block mb-2">Nama</label>
            <input name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full mb-3 p-2 border rounded">

            <label class="block mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full mb-3 p-2 border rounded">

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
        </form>

        <form method="POST" action="{{ route('marketing.profile.destroy') }}" class="mt-4">
            @csrf
            @method('DELETE')
            <input name="password" type="password" placeholder="Masukkan password untuk hapus akun" required class="w-full mb-3 p-2 border rounded">
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus Akun</button>
        </form>
    </div>
</body>
</html>