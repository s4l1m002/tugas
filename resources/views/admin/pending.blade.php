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
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Properti Menunggu Persetujuan</h1>
            @if(Auth::check() && in_array(Auth::user()->role, ['ketua', 'admin']))
                <a href="{{ route('admin.reports.index') }}" class="px-3 py-1 bg-indigo-600 text-white rounded">Panel Laporan</a>
            @endif
        </div>

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

        {{-- Daftar Transaksi yang perlu dikonfirmasi (admin/ketua) --}}
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Transaksi - Menunggu Konfirmasi Pembayaran</h2>
            @if(isset($transactions) && $transactions->isEmpty())
                <div class="p-4 bg-white rounded shadow">Tidak ada transaksi yang menunggu konfirmasi.</div>
            @else
                <div class="space-y-4">
                    @foreach($transactions as $tx)
                        <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                            <div>
                                <a href="{{ route('properties.show', $tx->property_id) }}" class="font-semibold text-indigo-700">{{ $tx->property->judul ?? 'Properti #' . $tx->property_id }}</a>
                                <div class="text-sm text-gray-600">Pelanggan ID: {{ $tx->pelanggan_id }}</div>
                                <div class="text-sm text-gray-600">Metode: {{ ucfirst($tx->pembayaran_metode ?? '-') }} {{ $tx->pembayaran_rekening ? '(Rek: ' . $tx->pembayaran_rekening . ')' : '' }}</div>
                                @if($tx->bukti)
                                    <div class="text-sm mt-1">Bukti: <a href="{{ asset($tx->bukti) }}" target="_blank" class="text-blue-600">Lihat Bukti</a></div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.transactions.confirm.admin', $tx->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded">Konfirmasi Lunas</button>
                                </form>
                                <form action="{{ route('admin.reject', $tx->property_id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 bg-red-500 text-white rounded">Tolak</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-sm text-blue-600">Kembali</a>
        </div>
    </div>
</body>
</html>