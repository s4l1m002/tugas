<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- pakai Facade agar Intelephense paham

class PropertyController extends Controller
{
    // Tampilkan daftar properti publik (yang sudah disetujui/admin publish)
    public function index(Request $request)
    {
        $properties = Property::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('properties.index', compact('properties'));
    }

    // Tampilkan detail properti
    public function show(Property $property)
    {
        // cek pemilik atau admin dengan cara yang Intelephense paham
        $isOwner = Auth::check() && Auth::id() === $property->user_id;
        $isAdmin = Auth::check() && (Auth::user()->role === 'admin');

        $hasTransactionForUser = false;
        if (Auth::check()) {
            $hasTransactionForUser = Transaction::where('property_id', $property->id)
                ->where('pelanggan_id', Auth::id())
                ->exists();
        }

        if ($property->status !== 'published' && ! $isOwner && ! $isAdmin && ! $hasTransactionForUser) {
            abort(404);
        }

        return view('properties.show', compact('property'));
    }
}