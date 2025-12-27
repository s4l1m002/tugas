<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Selamat Datang - Katalog Properti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <!-- Sidebar (Sesuai Desain Gambar) -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:block">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-10">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-800">One Realty Elite</span>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 bg-blue-50 text-blue-700 px-4 py-3 rounded-xl font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l-7 7m7-7v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </nav>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <h2 class="text-lg font-semibold text-gray-800">Ringkasan Utama</h2>
            <div class="flex items-center gap-4">
                @auth
                <div class="text-right mr-2">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pengguna Terdaftar</p>
                </div>
                {{-- Notifikasi link --}}
                <div class="mr-3">
                    <a href="{{ route('notifications.index') }}" class="flex items-center gap-2 text-sm text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                        </svg>
                        @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                        @if($unreadCount)
                            <span class="text-xs bg-red-500 text-white rounded-full px-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
                {{-- Dev: resend last contact notif button (pelanggan only) --}}
                @auth
                    @if(Auth::user()->role === 'pelanggan')
                        <div class="mr-3">
                            <form action="{{ route('dev.resend_last_contact') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Kirim Notif ke Marketing</button>
                            </form>
                        </div>
                    @endif
                @endauth
                {{-- Admin/Ketua: lihat properti pending --}}
                @if(in_array(Auth::user()->role, ['admin','ketua']))
                <div class="mr-3">
                    @php $pendingCount = \App\Models\Property::where('status','pending')->count(); @endphp
                    <a id="pending-link" href="{{ route('admin.pending') }}" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded">Pending (<span id="pending-count">{{ $pendingCount }}</span>)</a>
                </div>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
                @else
                <div class="space-x-2">
                    <a href="{{ route('login') }}" class="px-3 py-1 bg-indigo-600 text-white rounded">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-1 border rounded">Register</a>
                </div>
                @endauth
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-8">
            <div class="max-w-4xl">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang di Katalog Properti</h1>
                <p class="text-gray-500 mb-8">Temukan informasi mendasar mengenai pentingnya aset properti bagi masa depan Anda.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Card 1: Apa itu Properti -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mengenal Properti</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Properti adalah istilah untuk tanah atau bangunan yang dimiliki oleh seseorang atau badan usaha. Memiliki properti berarti Anda memiliki aset fisik yang memiliki nilai hukum dan ekonomi yang kuat.
                        </p>
                    </div>

                    <!-- Card 2: Nilai Investasi -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Aset Masa Depan</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Berbeda dengan barang konsumsi, nilai properti cenderung meningkat seiring berjalannya waktu. Hal ini menjadikan properti salah satu pilihan investasi yang paling diminati untuk perlindungan kekayaan.
                        </p>
                    </div>
                </div>

                <!-- Welcome Note -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 text-white p-8 rounded-3xl shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold mb-3">Wujudkan Hunian Impian</h2>
                        <p class="text-gray-300 leading-relaxed mb-6 max-w-lg">
                            Melalui dashboard ini, Anda dapat mulai menjelajahi berbagai tipe properti yang tersedia. Baik untuk tempat tinggal maupun kebutuhan bisnis, kami hadir untuk mempermudah pencarian Anda.
                        </p>
                        <a href="{{ route('properties.index') }}" class="inline-block bg-white text-gray-900 px-6 py-3 rounded-xl font-bold text-sm hover:bg-gray-100 transition-all">Jelajahi Katalog</a>
                    </div>
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
<script>
    // Poll pending count every 8 seconds for admin/ketua users.
    (function(){
        const role = '{{ auth()->user()->role ?? '' }}';
        if (role !== 'admin' && role !== 'ketua') return;

        async function fetchPending(){
            try{
                const res = await fetch('{{ route('admin.pending_count') }}', { credentials: 'same-origin' });
                if (!res.ok) return;
                const data = await res.json();
                const el = document.getElementById('pending-count');
                if (el && typeof data.pending !== 'undefined') el.textContent = data.pending;
            }catch(e){
                // ignore
            }
        }

        // initial fetch and interval
        fetchPending();
        setInterval(fetchPending, 8000);
    })();
</script>
</html>