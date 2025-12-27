<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Daftar Properti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-800 text-white px-6 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('properties.index') }}" class="font-bold">Logo</a>
            <div class="space-x-4">
                <a href="{{ route('properties.index') }}" class="hover:underline">Home</a>
                @guest
                    <a href="{{ route('login') }}" class="bg-indigo-600 px-3 py-1 rounded">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-1 border rounded">Register</a>
                @else
                    <span class="px-3 py-1">Hi, {{ auth()->user()->name }}</span>
                    <form class="inline" action="{{ route('logout') }}" method="POST">@csrf<button class="px-3 py-1 bg-red-600 rounded">Logout</button></form>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Items</h1>
            @auth
                @if(auth()->user()->role === 'marketing')
                    <a href="{{ route('marketing.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Upload</a>
                @endif
            @endauth
        </div>

        @if($properties->count() == 0)
            <p class="text-gray-600">Data ditampilkan 0 dari 0</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($properties as $p)
            <div class="bg-white rounded shadow overflow-hidden">
                <a href="{{ route('properties.show', $p->id) }}">
                    @php
                        $img = null;
                        if ($p->gambar) {
                            $img = str_starts_with($p->gambar, 'storage/') ? asset($p->gambar) : asset('storage/' . ltrim($p->gambar, '/'));
                        }
                    @endphp
                    <img class="w-full h-44 object-cover" src="{{ $img ?? '' }}" alt="{{ $p->judul }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x220?text=Gambar+tidak+tersedia';">
                </a>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">{{ $p->judul }}</h3>
                    <p class="text-sm text-gray-600 mb-2">IDR {{ number_format($p->harga,0,',','.') }}</p>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('properties.show', $p->id) }}" class="text-indigo-600 text-sm">Detail</a>
                        @if($p->status === 'sold')
                            <span class="text-red-600 font-bold">SOLD</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    </div>
</body>
</html>