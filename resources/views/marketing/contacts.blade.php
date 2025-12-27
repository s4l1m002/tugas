@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pesan Kontak Masuk</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if(empty($contacts) || $contacts->isEmpty())
        <div class="bg-white p-6 rounded shadow">Belum ada pesan masuk.</div>
    @else
        <div class="space-y-4">
            @foreach($contacts as $c)
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-sm text-gray-500">Properti ID: {{ $c->property_id }}</div>
                            <div class="font-medium">Dari: {{ optional($c->pelanggan)->name ?? 'Pelanggan' }} (ID: {{ $c->pelanggan_id }})</div>
                            <div class="text-gray-700 mt-2">{{ $c->pesan ?? '-' }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500 mb-2">Status: {{ strtoupper($c->status ?? 'pending') }}</div>
                            @if(($c->status ?? '') !== 'contacted')
                                <form action="{{ route('contact.mark_contacted', $c->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 bg-blue-600 text-white rounded">Tandai Sudah Dihubungi</button>
                                </form>
                            @else
                                <div class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm">Sudah dihubungi</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
