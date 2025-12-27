<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pending Properties</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Properti Menunggu Persetujuan</h1>

        @if($properties->isEmpty())
            <div class="p-4 bg-white rounded shadow">Tidak ada properti pending.</div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($properties as $prop)
                    <div class="bg-white p-4 rounded shadow flex justify-between items-start">
                        <div>
                            <h2 class="font-semibold">{{ $prop->judul }}</h2>
                            <p class="text-sm text-gray-600">{{ Str::limit($prop->deskripsi, 150) }}</p>
                            <p class="text-xs text-gray-500 mt-2">Uploaded by: {{ $prop->marketing->name ?? $prop->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-2">
                            <form action="{{ route('admin.approve', $prop->id) }}" method="POST">
                                @csrf
                                <button class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                            </form>

                            <form action="{{ route('admin.reject', $prop->id) }}" method="POST">
                                @csrf
                                <button class="px-3 py-1 bg-red-500 text-white rounded">Reject</button>
                            </form>

                            <a href="{{ route('properties.show', $prop->id) }}" class="text-sm text-blue-600">Lihat detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-sm text-blue-600">Kembali</a>
        </div>
    </div>
</body>
</html>