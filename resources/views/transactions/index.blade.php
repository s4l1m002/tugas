<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Transaksi Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-4xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Transaksi Saya</h1>

    <div class="mb-4">
        <a href="{{ route('transactions.create.form') }}" class="px-4 py-2 bg-green-600 text-white rounded">Buat Transaksi Baru</a>
    </div>

    @if($transactions->isEmpty())
        <div class="p-4 bg-white rounded shadow">Belum ada transaksi.</div>
    @else
        <div class="space-y-4">
            @foreach($transactions as $tx)
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <a href="{{ route('properties.show', $tx->property_id) }}" class="font-semibold text-lg text-indigo-700">{{ $tx->property->judul ?? 'Properti #' . $tx->property_id }}</a>
                        <div class="text-sm text-gray-600">Tanggal: {{ $tx->tanggal_transaksi }}</div>
                        <div class="text-sm text-gray-600">Harga: Rp {{ number_format($tx->harga_jual ?? 0,0,',','.') }}</div>
                        <div class="text-sm text-gray-600">Metode: {{ ucfirst($tx->pembayaran_metode ?? '-') }} {{ $tx->pembayaran_rekening ? '(Rek: ' . $tx->pembayaran_rekening . ')' : '' }}</div>
                        @if($tx->bukti)
                            <div class="text-sm mt-1">Bukti: <a href="{{ asset($tx->bukti) }}" target="_blank" class="text-blue-600">Lihat</a></div>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="px-3 py-1 rounded font-semibold {{ $tx->status_pembayaran === 'submitted' ? 'bg-yellow-100 text-yellow-800' : ($tx->status_pembayaran === 'paid' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">{{ strtoupper($tx->status_pembayaran) }}</div>
                        <a href="{{ route('properties.show', $tx->property_id) }}" class="inline-block mt-2 text-sm text-blue-600">Lihat Properti</a>
                        @if(Auth::check() && Auth::user()->role === 'pelanggan' && $tx->pembayaran_metode === 'cash' && $tx->status_pembayaran !== 'submitted')
                            <form method="POST" action="{{ route('transactions.confirm.customer', $tx->id) }}" class="mt-2">
                                @csrf
                                <button class="px-3 py-1 bg-yellow-500 text-white rounded text-sm">Konfirmasi Pembayaran (Cash)</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600">Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
