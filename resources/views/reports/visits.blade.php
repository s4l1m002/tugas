<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Kunjungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Laporan Kunjungan Rumah</h1>
            <div>
                <a href="{{ route('admin.reports.index') }}" class="ml-2 text-sm text-blue-600">Kembali</a>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Properti yang Sudah Dikunjungi</h2>
            <div>
                <button onclick="window.print()" class="px-3 py-2 bg-gray-800 text-white rounded">Cetak</button>
            </div>
        </div>

        @if($properties->isEmpty())
            <div class="p-4 bg-white rounded shadow">Belum ada properti yang ditandai 'Sudah Dikunjungi'.</div>
        @else
            <table class="w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Properti</th>
                        <th class="p-2 text-left">Marketing</th>
                        <th class="p-2 text-left">Uploaded</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $p)
                    <tr class="border-t">
                        <td class="p-2">{{ $p->id }}</td>
                        <td class="p-2">{{ $p->judul }}</td>
                        <td class="p-2">{{ $p->marketing->name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $p->created_at ? $p->created_at->format('Y-m-d') : '-' }}</td>
                        <td class="p-2"><a href="{{ route('properties.show', $p->id) }}" class="text-blue-600">Lihat</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</body>
</html>