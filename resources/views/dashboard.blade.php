<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aplikasi Properti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4">

    <!-- Konten Dashboard Utama -->
    <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-2xl border border-gray-100 text-center">
        
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-4">Selamat Datang di Dashboard!</h1>
        <p class="text-xl text-gray-600 mb-8">Anda berhasil masuk (Login) ke sistem.</p>
        
        <!-- Pesan Status -->
        @if(Auth::check())
    <div class="p-4 mb-6 text-base text-gray-700 bg-indigo-50 rounded-lg border border-indigo-200">
        Halo, {{ Auth::user()->name ?? 'Pengguna' }} (ID: {{ Auth::user()->id }}).
        <br>
        Anda adalah pengguna dengan <strong>Role: {{ Auth::user()->role ?? Auth::user()->role_id ?? 'N/A' }}</strong>.
    </div>
@endif

        <!-- Tombol Log Out -->
        <form method="POST" action="{{ route('logout') }}" class="inline-block">
            @csrf
            <button type="submit" class="flex items-center space-x-2 py-3 px-6 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200 ease-in-out">
                <!-- Icon Log Out (dari Lucide) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                <span>Keluar (Logout)</span>
            </button>
        </form>

    </div>

</body>
</html>