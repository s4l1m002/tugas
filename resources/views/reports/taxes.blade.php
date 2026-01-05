<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Pajak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Laporan Pajak</h1>
            <div>
                <a href="{{ route('admin.reports.index') }}" class="ml-2 text-sm text-blue-600">Kembali</a>
            </div>
        </div>

        <p class="text-gray-600">Ringkasan pajak untuk transaksi terbayar (Buyer + Seller tax = 7.5% dari harga jual):</p>
        <table class="mt-4 w-full mb-4">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 text-left">Transaksi</th>
                    <th class="p-2 text-left">Harga</th>
                    <th class="p-2 text-left">Pajak (7.5%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($taxDetails as $d)
                <tr class="border-t">
                    <td class="p-2">{{ $d->transaction->id }} - {{ $d->transaction->property->judul ?? 'Properti #' . $d->transaction->property_id }}</td>
                    <td class="p-2">Rp {{ number_format($d->harga,0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($d->tax,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bg-gray-50 p-3 rounded">
            <strong>Total Pajak (Buyer+Seller) Semua Transaksi:</strong>
            <div class="mt-2">Rp {{ number_format($totalTax,0,',','.') }}</div>
        </div>
    </div>
</body>
</html>