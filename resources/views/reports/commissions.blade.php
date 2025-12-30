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

        <table class="w-full table-auto text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-left">Properti</th>
                    <th class="p-2 text-left">Marketing</th>
                    <th class="p-2 text-left">Komisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr class="border-t">
                    <td class="p-2">{{ $t->id }}</td>
                    <td class="p-2">{{ $t->tanggal_transaksi }}</td>
                    <td class="p-2">{{ $t->property->judul ?? 'Properti #' . $t->property_id }}</td>
                    <td class="p-2">{{ $t->marketing->name ?? 'N/A' }}</td>
                    <td class="p-2">Rp {{ number_format($t->komisi_marketing ?? 0,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>