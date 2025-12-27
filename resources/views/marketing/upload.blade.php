<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing | Upload Properti Baru</title>
    {{-- Asumsi menggunakan Vite/Tailwind atau styling dasar --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .form-container { max-width: 700px; margin: 40px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #38a169; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="text-2xl font-bold mb-6">Upload Properti Baru</h1>
        <p class="mb-4 text-gray-600">Properti yang di-upload akan berstatus **Pending** dan perlu persetujuan Admin/Ketua.</p>

        {{-- Menampilkan pesan sukses atau error dari controller --}}
        @if(session('success'))
            <div style="background-color: #d1e7dd; color: #0f5132; padding: 10px; border: 1px solid #badbcc; border-radius: 4px; mb-4;">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM UPLOAD --}}
        {{-- WAJIB: enctype="multipart/form-data" untuk upload file --}}
        <form method="POST" action="{{ route('marketing.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- 1. Judul Properti --}}
            <div class="form-group">
                <label for="judul">Judul Properti</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required>
                @error('judul') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
            </div>

            {{-- 2. Deskripsi --}}
            <div class="form-group">
                <label for="deskripsi">Deskripsi Lengkap</label>
                <textarea name="deskripsi" id="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
            </div>

            {{-- 3. Harga --}}
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" required>
                @error('harga') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
            </div>

            {{-- 4. Alamat --}}
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" required>
                @error('alamat') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
            </div>
            
            {{-- 5. Luas Tanah & Bangunan (dalam m²) --}}
            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label for="luas_tanah">Luas Tanah (m²)</label>
                    <input type="number" name="luas_tanah" id="luas_tanah" value="{{ old('luas_tanah') }}">
                    @error('luas_tanah') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="luas_bangunan">Luas Bangunan (m²)</label>
                    <input type="number" name="luas_bangunan" id="luas_bangunan" value="{{ old('luas_bangunan') }}">
                    @error('luas_bangunan') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- 6. Upload Gambar --}}
            <div class="form-group">
                <label for="gambar">Gambar Properti</label>
                <input type="file" name="gambar" id="gambar" required>
                @error('gambar') <span style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Upload Properti</button>
        </form>
    </div>
</body>
</html>