<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Realty Elite - Katalog Properti</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .property-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }
        .card-img { width: 100%; height: 200px; object-fit: cover; }
        .card-body { padding: 15px; }
        .price { font-size: 1.4em; color: #38a169; font-weight: bold; margin-bottom: 10px; }
        .pagination { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Katalog Properti Unggulan</h1>
        <hr>

        @if(session('error'))
            <div style="color: rgb(158, 158, 158); padding: 10px; border: 1px solid red;">{{ session('error') }}</div>
        @endif

        <div class="property-grid">
            @forelse ($properties as $property)
                @include('components._property_card', ['property' => $property])
            @empty
                <p>Saat ini belum ada properti yang tersedia atau yang telah disetujui.</p>
            @endforelse
        </div>

        <div class="pagination">
            {{ $properties->links() }}
        </div>

    </div>
</body>
</html>