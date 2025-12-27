<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - {{ $property->judul }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>.container{max-width:800px;margin:40px auto;padding:20px}</style>
</head>
<body>
<div class="container">
    <a href="{{ route('properties.show', $property->id) }}" class="text-blue-500">&larr; Kembali</a>
    <h1 class="text-2xl font-bold mt-4 mb-4">Pembayaran untuk: {{ $property->judul }}</h1>

    @if(session('success'))
        <div class="bg-green-100 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('transactions.purchase', $property->id) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium">Pilih Metode Pembayaran</label>
            <div class="mt-2 space-x-4">
                <label class="inline-flex items-center"><input type="radio" name="payment_method" value="cash" checked> <span class="ml-2">Cash</span></label>
                <label class="inline-flex items-center"><input type="radio" name="payment_method" value="transfer"> <span class="ml-2">Transfer</span></label>
            </div>
        </div>

        <div>
            <label class="block font-medium">No. Rekening (jika transfer)</label>
            <input type="text" name="rekening" value="123456789" class="w-full border rounded p-2" placeholder="Contoh: 123456789">
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Laporkan Pembayaran</button>
            <a href="{{ route('properties.show', $property->id) }}" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
