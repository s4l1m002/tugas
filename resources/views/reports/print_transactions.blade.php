<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak Laporan Transaksi</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding:6px; }
        th { background:#eee; }
        @media print { button#print { display:none; } }
    </style>
</head>
<body>
    <div style="margin-bottom:12px;">
        <button id="print" onclick="window.print()" style="padding:8px 12px; background:#222; color:#fff; border:none; border-radius:4px;">Cetak</button>
    </div>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Properti</th>
                <th>Pelanggan</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->tanggal_transaksi }}</td>
                <td>{{ $t->property->judul ?? 'Properti #' . $t->property_id }}</td>
                <td>{{ $t->pelanggan_id }}</td>
                <td>Rp {{ number_format($t->harga_jual,0,',','.') }}</td>
                <td>{{ strtoupper($t->status_pembayaran) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>