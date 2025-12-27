@php
    // Asumsi Anda memiliki layout dasar (misalnya app.blade.php)
    // Jika tidak, ganti dengan tag <html>, <head>, dan <body>
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->judul }} - Detail</title>
    {{-- Asumsi Anda menggunakan Vite/Tailwind untuk styling --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .container-detail { max-width: 1000px; margin: 40px auto; padding: 20px; }
        .grid-detail { display: flex; gap: 30px; }
        .main-info { flex: 2; }
        .side-info { flex: 1; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .property-image { max-width: 100%; height: auto; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container-detail">
        {{-- Tombol Kembali --}}
        <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 mb-4 inline-block">&larr; Kembali ke Katalog</a>

        <div class="grid-detail">
            
            {{-- 1. INFORMASI UTAMA (GAMBAR & DESKRIPSI) --}}
            <div class="main-info">
                <h1 class="text-3xl font-bold mb-4">{{ $property->judul }}</h1>
                
                @if ($property->gambar)
                    @php
                        $img = str_starts_with($property->gambar, 'storage/') ? asset($property->gambar) : asset('storage/' . ltrim($property->gambar, '/'));
                    @endphp
                    <img src="{{ $img }}" alt="{{ $property->judul }}" class="property-image mb-6" onerror="this.onerror=null;this.src='https://via.placeholder.com/800x500?text=Gambar+tidak+tersedia';">
                @else
                    <div class="bg-gray-200 h-96 flex items-center justify-center mb-6 rounded-lg">Gambar Tidak Tersedia</div>
                @endif
                
                <h2 class="text-2xl font-semibold mb-2">Deskripsi</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $property->deskripsi }}</p>

                {{-- Detail Tambahan --}}
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-xl font-semibold mb-3">Spesifikasi</h3>
                    <ul class="list-disc list-inside">
                        <li>Luas Tanah: **{{ $property->luas_tanah }} m²**</li>
                        <li>Luas Bangunan: **{{ $property->luas_bangunan }} m²**</li>
                        <li>Alamat: **{{ $property->alamat }}**</li>
                        {{-- Tambahkan detail lain seperti Kamar Tidur/Mandi jika ada di migration --}}
                    </ul>
                </div>
            </div>

            {{-- 2. SIDEBAR (HARGA & KONTAK) --}}
            <div class="side-info">
                
                {{-- Harga --}}
                <div class="mb-6">
                    <p class="text-xl text-gray-600">Harga Jual:</p>
                    <p class="text-4xl font-extrabold text-green-600">
                        Rp {{ number_format($property->harga, 0, ',', '.') }}
                    </p>
                </div>
                
                {{-- Status dan Marketing --}}
                <div class="text-sm text-gray-500 border-b pb-4 mb-4">
                    @if ($property->marketing)
                        <p>Di-upload oleh Marketing: **{{ $property->marketing->name }}**</p>
                    @endif
                    <p>Status: <span class="font-semibold text-green-500">DISETUJUI</span></p>
                </div>

                {{-- Form Kontak Marketing --}}
                <h3 class="text-xl font-semibold mb-3">Tertarik dengan Properti Ini?</h3>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(Auth::check())
                    @if(Auth::user()->role === 'pelanggan')
                        {{-- FORM KONTAK (Hanya terlihat oleh Pelanggan) --}}
                        {{-- Perbaikan: gunakan nama route yang terdaftar di web.php yaitu 'contact.store' --}}
                        <form method="POST" action="{{ route('contact.store', $property->id) }}" class="space-y-4">
                            @csrf
                            <p class="text-gray-600">Anda akan menghubungi **{{ $property->marketing->name ?? 'Marketing' }}**.</p>
                            
                            <div>
                                <label for="pesan" class="block text-sm font-medium text-gray-700">Pesan Tambahan (Opsional):</label>
                                <textarea name="pesan" id="pesan" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Contoh: Saya ingin survei properti ini besok sore."></textarea>
                                @error('pesan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-bold transition duration-150">
                                Kirim Permintaan Kontak
                            </button>
                        </form>
                    
                        {{-- Opsi: Pelanggan setuju -> buat transaksi & bayar --}}
                        <div class="mt-4">
                            <a href="{{ route('transactions.purchase.form', $property->id) }}" class="block text-center bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Saya Setuju, Lanjut ke Pembayaran</a>
                        </div>
                    @else
                        {{-- Marketing/Admin/Pajak tidak bisa kontak --}}
                        <p class="text-yellow-600">Anda login sebagai **{{ ucfirst(Auth::user()->role) }}**. Hanya Pelanggan yang dapat mengajukan permintaan kontak.</p>
                    @endif
                @else
                    {{-- Belum Login --}}
                    <div class="p-4 bg-red-100 border border-red-400 rounded-lg">
                        <p class="text-red-700 mb-2">Silakan login sebagai Pelanggan untuk menghubungi Marketing.</p>
                        <a href="{{ route('login') }}" class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Login Sekarang</a>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</body>
</html>