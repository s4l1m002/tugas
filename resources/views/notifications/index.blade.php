<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Notifikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Notifikasi Anda</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-lg font-semibold">Belum dibaca</h2>
    @if($unread->isEmpty())
        <p class="text-sm text-gray-500 mb-4">Tidak ada notifikasi baru.</p>
    @else
        <ul class="space-y-3 mb-6">
            @foreach($unread as $note)
                <li class="p-3 bg-white border rounded flex justify-between items-start">
                    <div>
                        @php
                            $body = $note->data['text'] ?? $note->data['message'] ?? 'Notifikasi baru';
                        @endphp
                        <p class="text-sm">{!! $body !!}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                    </div>
                    <form action="{{ route('notifications.read', $note->id) }}" method="POST">
                        @csrf
                        <button class="text-sm text-blue-600">Tandai dibaca</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

    <h2 class="text-lg font-semibold">Riwayat</h2>
    @if($read->isEmpty())
        <p class="text-sm text-gray-500">Belum ada notifikasi lama.</p>
    @else
        <ul class="space-y-3">
            @foreach($read as $note)
                <li class="p-3 bg-gray-50 border rounded">
                    <p class="text-sm">{!! $note->data['text'] ?? 'Notifikasi' !!}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                </li>
            @endforeach
        </ul>
    @endif

    <div class="mt-6">
        <a href="{{ route('home') }}" class="text-sm text-blue-600">Kembali ke beranda</a>
    </div>
</div>
</body>
</html>
