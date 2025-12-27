<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-4">
            Lupa Kata Sandi Anda?
        </h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan untuk reset password.
        </p>

        {{-- Pesan Status (misalnya: link sudah dikirim) --}}
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            {{-- Bidang Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Kirim Link --}}
            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    Kirim Tautan Reset Password
                </button>
            </div>
        </form>

        {{-- Link Kembali ke Login --}}
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="font-medium text-sm text-blue-600 hover:text-blue-500">
                &larr; Kembali ke Halaman Login
            </a>
        </div>
    </div>
</body>
</html>