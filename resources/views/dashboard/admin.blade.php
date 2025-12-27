<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-600">Admin Panel</h1>
        <div>
            <span class="text-gray-700 mr-4">Selamat Datang, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition duration-150">Logout</button>
            </form>
        </div>
    </nav>
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 border-b pb-3">Selamat Datang di Dashboard Admin</h2>
            <p class="text-gray-600">Di sini adalah tempat Anda mengelola semua data properti, pengguna, dan transaksi.</p>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-indigo-700 text-xl mb-2">Manajemen Properti</h3>
                    <p class="text-indigo-600">Setujui properti, atau hapus properti yang tidak valid.</p>
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-yellow-700 text-xl mb-2">Manajemen Pengguna</h3>
                    <p class="text-yellow-600">Kelola role dan data pengguna di sistem.</p>
                </div>
                <div class="bg-green-100 p-6 rounded-lg shadow-md">
                    <h3 class="font-bold text-green-700 text-xl mb-2">Laporan Transaksi</h3>
                    <p class="text-green-600">Lihat ringkasan dan detail semua transaksi.</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>