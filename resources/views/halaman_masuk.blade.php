<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md text-center">
        <h1 class="text-3xl font-bold mb-4">Aplikasi Katalog Properti</h1>
        <p class="text-gray-600 mb-6">Selamat datang! Lihat daftar properti kami.</p>
        <a href="{{ route('properties.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg">Lihat Properti</a>
        <div class="mt-4 text-sm text-gray-400">Atau masuk ke <a href="{{ route('login') }}" class="text-indigo-600">Login/Register</a></div>
    </div>
</body>
</html>