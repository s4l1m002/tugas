<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Buat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="max-w-2xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Buat Transaksi Baru</h1>

    @if(session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('transactions.store.customer') }}" class="bg-white p-6 rounded shadow" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1">Pilih Properti</label>
            <select name="property_id" class="w-full border rounded p-2">
                <option value="">-- Pilih Properti --</option>
                @foreach($properties as $p)
                    <option value="{{ $p->id }}">#{{ $p->id }} - {{ $p->judul }} (Rp {{ number_format($p->harga,0,',','.') }})</option>
                @endforeach
            </select>
            @error('property_id')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Metode Pembayaran</label>
            <label class="inline-flex items-center mr-4"><input type="radio" name="payment_method" value="cash" checked> <span class="ml-2">Cash</span></label>
            <label class="inline-flex items-center"><input type="radio" name="payment_method" value="transfer"> <span class="ml-2">Transfer</span></label>
            @error('payment_method')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">No. Rekening (jika transfer)</label>
            <input type="text" name="rekening" value="123456789" class="w-full border rounded p-2" placeholder="123456789">
            @error('rekening')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Bukti Pembayaran (opsional, jika transfer)</label>
            <input type="file" name="bukti" accept="image/*,application/pdf" class="w-full">
            @error('bukti')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Kirim & Laporkan Pembayaran</button>
            <a href="{{ route('transactions.my') }}" class="px-4 py-2 border rounded">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
