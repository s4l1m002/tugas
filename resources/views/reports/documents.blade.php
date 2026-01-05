<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Dokumen Properti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Laporan Dokumen Properti</h1>
            <div>
                <a href="{{ route('admin.reports.index') }}" class="ml-2 text-sm text-blue-600">Kembali</a>
            </div>
        </div>

        <table class="w-full table-auto text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 text-left">Properti</th>
                    <th class="p-2 text-left">Marketing</th>
                    <th class="p-2 text-left">IMB</th>
                    <th class="p-2 text-left">PBB</th>
                    <th class="p-2 text-left">Sertifikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($properties as $p)
                <tr class="border-t">
                    <td class="p-2">{{ $p->judul }}</td>
                    <td class="p-2">{{ $p->marketing->name ?? 'N/A' }}</td>
                    <td class="p-2">
                        @if(isset($p->imb_complete) && $p->imb_complete)
                            Lengkap
                        @elseif($p->transactions()->where('status_pembayaran','paid')->exists())
                            Lengkap
                        @else
                            {{ $p->imb ?? $p->dokumen_imb ?? 'Tidak ada' }}
                        @endif
                    </td>
                    <td class="p-2">
                        @if(isset($p->pbb_complete) && $p->pbb_complete)
                            Lengkap
                        @elseif($p->transactions()->where('status_pembayaran','paid')->exists())
                            Lengkap
                        @else
                            {{ $p->pbb ?? $p->dokumen_pbb ?? 'Tidak ada' }}
                        @endif
                    </td>
                    <td class="p-2">
                        @if(isset($p->sertifikat_complete) && $p->sertifikat_complete)
                            Lengkap
                        @elseif($p->transactions()->where('status_pembayaran','paid')->exists())
                            Lengkap
                        @else
                            {{ $p->sertifikat ?? $p->dokumen_sertifikat ?? $p->dokumen ?? 'Tidak ada' }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>