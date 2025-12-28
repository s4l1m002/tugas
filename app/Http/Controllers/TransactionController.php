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

        
        // determine marketing_id fallback
        $marketingId = $property->marketing_id ?? $property->user_id;
        if (! $marketingId) {
            $marketingId = \App\Models\User::where('role', 'marketing')->value('id') ?: \App\Models\User::where('role', 'admin')->value('id');
        }
        if (! $marketingId) {
            return back()->with('error', 'Tidak ada akun marketing/admin tersedia untuk ditugaskan pada transaksi.');
        }

        Transaction::create([
            'property_id' => $property->id,
            'marketing_id' => $marketingId,
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

        // determine marketing_id fallback
        $marketingId = $property->marketing_id ?? $property->user_id;
        if (! $marketingId) {
            $marketingId = \App\Models\User::where('role', 'marketing')->value('id') ?: \App\Models\User::where('role', 'admin')->value('id');
        }
        if (! $marketingId) {
            return back()->with('error', 'Tidak ada akun marketing/admin tersedia untuk ditugaskan pada transaksi.');
        }

        $tx = Transaction::create([
            'property_id' => $property->id,
            'marketing_id' => $marketingId,
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

    // Tampilkan daftar transaksi untuk pelanggan yang sedang login
    public function myTransactions(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $transactions = Transaction::where('pelanggan_id', $user->id)
            ->with('property')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    // Customer confirms payment (for cash) — send notification to admin/ketua/marketing
    public function customerConfirm(Request $request, Transaction $transaction)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'pelanggan' || $transaction->pelanggan_id !== $user->id) {
            abort(403);
        }

        // mark as submitted (if not already) and notify
        $transaction->status_pembayaran = 'submitted';
        $transaction->save();

        $property = $transaction->property;
        $notifiables = \App\Models\User::whereIn('role', ['admin','ketua'])->get();
        if ($property && $property->marketing) $notifiables->push($property->marketing);

        foreach ($notifiables as $n) {
            try { $n->notify(new \App\Notifications\PaymentSubmitted($transaction)); } catch (\Throwable $e) { \Log::error($e->getMessage()); }
        }

        return redirect()->route('transactions.my')->with('success', 'Konfirmasi pembayaran terkirim. Admin akan memeriksa.');
    }

    // Admin confirms a transaction as paid
    public function adminConfirm(Request $request, Transaction $transaction)
    {
        $user = $request->user();
        if (! $user || ! in_array($user->role, ['admin','ketua'])) {
            abort(403);
        }

        $transaction->status_pembayaran = 'paid';
        $transaction->save();

        // update property status to sold
        if ($transaction->property) {
            $transaction->property->update(['status' => 'sold']);
        }

        // notify pelanggan and marketing
        $notifiables = collect();
        if ($transaction->pelanggan_id) {
            $notifiables->push(\App\Models\User::find($transaction->pelanggan_id));
        }
        if ($transaction->marketing) {
            $notifiables->push($transaction->marketing);
        }

        foreach ($notifiables as $n) {
            if (! $n) continue;
            try { $n->notify(new \App\Notifications\PaymentConfirmed($transaction)); } catch (\Throwable $e) { \Log::error($e->getMessage()); }
        }

        return back()->with('success', 'Transaksi telah dikonfirmasi sebagai LUNAS.');
    }

    // Show form for pelanggan to create a new transaction (select property + payment)
    public function createForCustomer(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'pelanggan') {
            return redirect()->route('login');
        }

        // List properties that are available for purchase (not sold)
        $properties = Property::where('status', 'published')->where('status','!=','sold')->get();
        return view('transactions.create', compact('properties'));
    }

    // Store transaction submitted by pelanggan from the transactions.create form
    public function storeCustomer(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'pelanggan') {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'payment_method' => 'required|in:cash,transfer',
            'rekening' => 'nullable|string',
        ]);

        $property = Property::find($validated['property_id']);
        if (! $property || $property->status === 'sold') {
            return back()->with('error', 'Properti tidak tersedia untuk transaksi.');
        }

        $hargaJual = $property->harga ?? 0;
        $komisiPersen = config('app.default_komisi', 2);
        $komisiMarketing = ($hargaJual * $komisiPersen) / 100;

        // determine marketing_id: prefer property's marketing_id, then property's user_id, then fallback to any marketing/admin user
        $marketingId = $property->marketing_id ?? $property->user_id;
        if (! $marketingId) {
            $marketingId = \App\Models\User::where('role', 'marketing')->value('id') ?: \App\Models\User::where('role', 'admin')->value('id');
        }
        if (! $marketingId) {
            return back()->with('error', 'Tidak ada akun marketing/admin tersedia untuk ditugaskan pada transaksi. Hubungi administrator.');
        }

        $txData = [
            'property_id' => $property->id,
            'marketing_id' => $marketingId,
            'pelanggan_id' => $user->id,
            'tanggal_transaksi' => now()->toDateString(),
            'harga_jual' => $hargaJual,
            'komisi_persen' => $komisiPersen,
            'komisi_marketing' => $komisiMarketing,
            'status_pembayaran' => 'submitted',
            'pembayaran_metode' => $validated['payment_method'],
            'pembayaran_rekening' => $validated['rekening'] ?? null,
        ];

        // If transfer and file present, store proof
        if ($request->hasFile('bukti') && $request->file('bukti')->isValid()) {
            $file = $request->file('bukti');
            $name = 'bukti_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('payments', $file, $name);
            $txData['bukti'] = 'storage/payments/' . $name;
        }

        $tx = Transaction::create($txData);

        // Notify admin, ketua, marketing
        $notifiables = \App\Models\User::whereIn('role', ['admin','ketua'])->get();
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

        // Update property status to pending_transaction
        $property->update(['status' => 'pending_transaction']);

        return redirect()->route('transactions.my')->with('success', 'Transaksi dibuat dan pembayaran dilaporkan. Admin akan memeriksa.');
    }
}