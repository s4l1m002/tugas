<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan - Ketua</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Panel Laporan - Ketua</h1>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.reports.transactions') }}" class="text-blue-600">Laporan Transaksi</a></li>
            <li><a href="{{ route('admin.reports.commissions') }}" class="text-blue-600">Laporan Pembayaran Komisi</a></li>
            <li><a href="{{ route('admin.reports.visits') }}" class="text-blue-600">Laporan Kunjungan Rumah</a></li>
            <li><a href="{{ route('admin.reports.documents') }}" class="text-blue-600">Laporan Dokumen Properti</a></li>
            <li><a href="{{ route('admin.reports.taxes') }}" class="text-blue-600">Laporan Pajak</a></li>
        </ul>
    </div>
</body>
</html>