<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Properties</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Properti Saya</h1>

        @if($properties->isEmpty())
            <div class="p-4 bg-white rounded shadow">Anda belum meng-upload properti apapun.</div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($properties as $prop)
                    <div class="bg-white p-4 rounded shadow flex justify-between items-start">
                        <div>
                            <h2 class="font-semibold">{{ $prop->judul }}</h2>
                            <p class="text-sm text-gray-600">Status: <span class="font-medium">{{ $prop->status }}</span></p>
                            <p class="text-xs text-gray-500 mt-2">{{ Str::limit($prop->deskripsi, 120) }}</p>
                        </div>
                        <div class="space-y-2 text-right">
                            <a href="{{ route('properties.show', $prop->id) }}" class="text-sm text-blue-600">Detail</a>
                            <form action="{{ route('marketing.destroy', $prop->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm text-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('marketing.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Upload Properti Baru</a>
        </div>
    </div>
</body>
</html>