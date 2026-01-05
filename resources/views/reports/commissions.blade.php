<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Komisi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Laporan Pembayaran Komisi</h1>
            <div>
                <a href="{{ route('admin.reports.index') }}" class="ml-2 text-sm text-blue-600">Kembali</a>
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-3">Detail Komisi Per Transaksi</h2>
        <table class="w-full table-auto text-sm mb-6">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-left">Properti</th>
                    <th class="p-2 text-left">Marketing</th>
                    <th class="p-2 text-left">Harga</th>
                    <th class="p-2 text-left">Office Fee (3%)</th>
                    <th class="p-2 text-left">Marketing Gross (70%)</th>
                    <th class="p-2 text-left">Marketing Tax (2.5%)</th>
                    <th class="p-2 text-left">Marketing Net</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $d)
                <tr class="border-t">
                    <td class="p-2">{{ $d->transaction->id }}</td>
                    <td class="p-2">{{ $d->transaction->tanggal_transaksi }}</td>
                    <td class="p-2">{{ $d->transaction->property->judul ?? 'Properti #' . $d->transaction->property_id }}</td>
                    <td class="p-2">{{ $d->transaction->marketing->name ?? ($d->transaction->property->marketing->name ?? 'N/A') }}</td>
                    <td class="p-2">Rp {{ number_format($d->harga,0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($d->office_fee,0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($d->marketing_gross,0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($d->marketing_tax,0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($d->marketing_net,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-lg font-semibold mb-3">Ringkasan Pajak & Komisi per Marketing</h2>
        <table class="w-full table-auto text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 text-left">Marketing</th>
                    <th class="p-2 text-left">Total Gross</th>
                    <th class="p-2 text-left">Total Pajak</th>
                    <th class="p-2 text-left">Total Net</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marketingSummary as $m)
                <tr class="border-t">
                    <td class="p-2">{{ $m['name'] ?? $m['marketing_id'] }}</td>
                    <td class="p-2">Rp {{ number_format($m['gross'],0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($m['tax'],0,',','.') }}</td>
                    <td class="p-2">Rp {{ number_format($m['net'],0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>