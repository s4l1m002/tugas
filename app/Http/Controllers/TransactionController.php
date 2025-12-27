<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    
    public function create(Property $property)
    {
        
        if ($property->status !== 'approved') {
            return redirect()->route('admin.pending')->with('error', 'Properti belum disetujui atau sudah terjual.');
        }

        
        return view('admin.transaction.create', compact('property'));
    }
    public function store(Request $request, Property $property)
    {
       
        $validatedData = $request->validate([
            'harga_jual' => 'required|numeric|min:1000',
            'komisi_persen' => 'required|numeric|min:0|max:100',
            'tanggal_transaksi' => 'required|date',
        ]);

        
        $hargaJual = $validatedData['harga_jual'];
        $komisiPersen = $validatedData['komisi_persen'];
        $komisiMarketing = ($hargaJual * $komisiPersen) / 100;

        
        Transaction::create([
            'property_id' => $property->id,
            'marketing_id' => $property->marketing_id, 
            'tanggal_transaksi' => $validatedData['tanggal_transaksi'],
            'harga_jual' => $hargaJual,
            'komisi_persen' => $komisiPersen,
            'komisi_marketing' => $komisiMarketing,
            'status_pembayaran' => 'pending', 
        ]);
        
        
        $property->update(['status' => 'sold']);

        return redirect()->route('admin.pending')->with('success', 'Transaksi penjualan properti berhasil dicatat dan status properti diubah menjadi SOLD.');
    }

    // Form for pelanggan to submit payment intent
    public function purchaseForm(Property $property)
    {
        if (!auth()->check() || auth()->user()->role !== 'pelanggan') {
            return redirect()->route('properties.show', $property->id)->with('error', 'Hanya pelanggan yang dapat melakukan pembelian.');
        }

        return view('properties.purchase', compact('property'));
    }

    // Handle pelanggan purchase submission (payment method)
    public function purchase(Request $request, Property $property)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
            'rekening' => 'nullable|string',
        ]);

        $user = auth()->user();

        $hargaJual = $property->harga ?? 0;
        $komisiPersen = config('app.default_komisi', 2); // fallback
        $komisiMarketing = ($hargaJual * $komisiPersen) / 100;

        $tx = Transaction::create([
            'property_id' => $property->id,
            'marketing_id' => $property->marketing_id,
            'pelanggan_id' => $user->id,
            'tanggal_transaksi' => now()->toDateString(),
            'harga_jual' => $hargaJual,
            'komisi_persen' => $komisiPersen,
            'komisi_marketing' => $komisiMarketing,
            'status_pembayaran' => 'submitted',
            'pembayaran_metode' => $request->input('payment_method'),
            'pembayaran_rekening' => $request->input('rekening'),
        ]);

        // Notify admin, ketua, marketing
        $notifiables = \App\Models\User::whereIn('role', ['admin','ketua'])->get();
        // include property marketing user if present
        if ($property->marketing) {
            $notifiables->push($property->marketing);
        }

        foreach ($notifiables as $n) {
            try {
                $n->notify(new \App\Notifications\PaymentSubmitted($tx));
            } catch (\Throwable $e) {
                \Log::error('Notify failed: ' . $e->getMessage());
            }
        }

        // update property status to pending_transaction
        $property->update(['status' => 'pending_transaction']);

        return redirect()->route('properties.show', $property->id)->with('success', 'Pembayaran dilaporkan. Admin akan memeriksa dan mengonfirmasi.');
    }
}