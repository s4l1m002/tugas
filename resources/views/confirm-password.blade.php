<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Kata Sandi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-4">
            Area Terbatas
        </h2>
        <p class="text-sm text-gray-600 mb-6 text-center">
            Ini adalah area aman aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

            {{-- Bidang Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input id="password" type="password" name="password" required autofocus 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Konfirmasi --}}
            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</body>
</html>