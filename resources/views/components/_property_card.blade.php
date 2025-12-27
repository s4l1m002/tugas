<div class="card">
    @if ($property->gambar)
        @php
            $img = str_starts_with($property->gambar, 'storage/') ? asset($property->gambar) : asset('storage/' . ltrim($property->gambar, '/'));
        @endphp
        <img src="{{ $img }}" alt="{{ $property->judul }}" class="card-img" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x220?text=Gambar+tidak+tersedia';">
    @else
        <img src="{{ asset('images/default.jpg') }}" alt="No Image" class="card-img">
    @endif

    <div class="card-body">
        <h3 style="font-size: 1.2em; margin-bottom: 5px;">{{ $property->judul }}</h3>
        
        <div class="price">
            Rp {{ number_format($property->harga, 0, ',', '.') }}
        </div>

        <p style="font-size: 0.9em; color: #555;">
            Luas: LT {{ $property->luas_tanah }}m² / LB {{ $property->luas_bangunan }}m²
        </p>

        <a href="{{ route('property.show', $property->id) }}" style="display: block; text-align: center; background-color: #3182ce; color: white; padding: 10px; border-radius: 4px; text-decoration: none; margin-top: 10px;">
            Lihat Detail
        </a>
        
    </div>
</div>