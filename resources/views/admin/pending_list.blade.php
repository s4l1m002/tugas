<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Properti Pending</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-indigo-700 shadow p-4 flex justify-between items-center text-white">
        <h1 class="text-2xl font-bold">Admin Panel (Pending)</h1>
        <div>
            <span class="mr-4">Halo, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition duration-150">Logout</button>
            </form>
        </div>
    </nav>
    
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Daftar Properti Menunggu Persetujuan</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($properties->isEmpty())
            <div class="text-center p-10 bg-white rounded-xl shadow-lg">
                <p class="text-xl text-gray-500">Tidak ada properti yang sedang menunggu persetujuan.</p>
            </div>
        @else
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Properti</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marketing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($properties as $property)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $property->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $property->marketing_id }} 
                                {{-- Jika Anda punya relasi, gunakan: $property->marketing->name --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $property->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                {{-- Form Persetujuan --}}
                                <form action="{{ route('admin.approve', $property) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 border border-green-500 px-2 py-1 rounded-lg text-xs font-semibold">
                                        Setujui
                                    </button>
                                </form>
                                {{-- Form Penolakan --}}
                                <form action="{{ route('admin.reject', $property) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900 border border-red-500 px-2 py-1 rounded-lg text-xs font-semibold">
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</body>
</html>