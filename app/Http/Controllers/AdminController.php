<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property; // Pastikan Model Property di-import dengan benar
use App\Models\User; // Asumsi jika ingin menampilkan nama marketing
use App\Notifications\PropertyStatusChanged;

class AdminController extends Controller
{
    // Method yang dipanggil oleh route admin.pending (route('admin.pending'))
    public function pendingProperties()
    {
        // Hanya admin atau ketua yang boleh mengakses
        $user = auth()->user();
        if (! $user || ! in_array($user->role, ['admin', 'ketua'])) {
            abort(403, 'This action is unauthorized.');
        }

        // Ambil semua properti dengan status 'pending'
        $properties = Property::where('status', 'pending')
                             ->latest()
                             ->get();

        return view('admin.pending', compact('properties'));
    }

    /**
     * Return JSON with pending properties count. Used by frontend to poll for updates.
     */
    public function pendingCount()
    {
        $user = auth()->user();
        if (! $user || ! in_array($user->role, ['admin', 'ketua'])) {
            return response()->json(['error' => 'unauthorized'], 403);
        }

        $count = Property::where('status', 'pending')->count();
        return response()->json(['pending' => $count]);
    }

    // Method untuk menyetujui properti
    public function approve(Property $property)
    {
        $oldStatus = $property->status;
        $property->status = 'published';
        $property->save();

        try {
            if ($property->marketing_id) {
                $owner = User::find($property->marketing_id);
            } else {
                $owner = User::find($property->user_id);
            }
            if ($owner) {
                $owner->notify(new PropertyStatusChanged($property, $oldStatus, 'published'));
            }
        } catch (\Exception $e) {
            logger()->error('Notify owner on approve failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Properti berhasil disetujui dan kini tampil di katalog.');
    }

    // Method untuk menolak properti
    public function reject(Property $property)
    {
        $oldStatus = $property->status;
        $property->status = 'rejected';
        $property->save();

        try {
            if ($property->marketing_id) {
                $owner = User::find($property->marketing_id);
            } else {
                $owner = User::find($property->user_id);
            }
            if ($owner) {
                $owner->notify(new PropertyStatusChanged($property, $oldStatus, 'rejected'));
            }
        } catch (\Exception $e) {
            logger()->error('Notify owner on reject failed: ' . $e->getMessage());
        }
        
        return back()->with('success', 'Properti berhasil ditolak.');
    }
}