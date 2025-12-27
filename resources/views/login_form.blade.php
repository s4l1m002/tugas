<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Masuk - Aplikasi Properti</title>
    <!-- Memuat Tailwind CSS CDN untuk styling yang mudah dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menggunakan font Inter untuk tampilan modern */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef2f6; /* Warna latar belakang ringan */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <!-- Card Login Utama -->
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl transition duration-300 hover:shadow-xl border border-gray-100">
        
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Selamat Datang</h2>
        <p class="text-center text-gray-500 mb-6">Silakan masuk untuk melanjutkan ke dashboard.</p>

        <!-- Pesan Status (Success atau Error) -->
        @if(session('success'))
            <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <!-- Menampilkan pesan error validasi (yang dikirim dari Controller) -->
            <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                Kredensial atau input tidak valid. Mohon periksa kembali.
            </div>
        @endif
        
        <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
            @csrf

            <!-- Input Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400
                                 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror" 
                        placeholder="Masukkan email Anda">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input id="password" type="password" name="password" required 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400
                                 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror" 
                        placeholder="Masukkan kata sandi">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me dan Lupa Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900 select-none">Ingat Saya</label>
                </div>
                
                <!-- Link Forgot Password (Jika ada rute reset password) -->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium transition duration-150 ease-in-out">Lupa Kata Sandi?</a>
                @endif
            </div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 ease-in-out">
                    MASUK
                </button>
            </div>
        </form>
        
        <!-- Link Register -->
        <div class="mt-8 text-center text-sm text-gray-600">
            Belum punya akun? 
            <!-- Perluas dengan rute register Anda jika ada -->
            <a href="/register" class="font-bold text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out">Daftar sekarang</a>
        </div>
    </div>

</body>
</html>