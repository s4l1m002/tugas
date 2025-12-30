<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewProperty;
use App\Models\User;

class MarketingController extends Controller
{
    // Menampilkan daftar properti yang diupload oleh marketing yang sedang login
    public function index()
    {
        // Toleransi terhadap skema DB yang berubah: beberapa tabel memakai
        // kolom 'marketing_id', sedangkan yang lain menggunakan 'user_id'.
        $ownerColumn = Schema::hasColumn('properties', 'marketing_id') ? 'marketing_id' : 'user_id';
        $properties = Property::where($ownerColumn, Auth::id())->latest()->get();
        return view('marketing.my_properties', compact('properties'));
    }

    /**
     * Show incoming contacts for the logged-in marketing user.
     */
    public function contacts()
    {
        $ownerColumn = \Illuminate\Support\Facades\Schema::hasColumn('properties', 'marketing_id') ? 'marketing_id' : 'user_id';

        // properties owned by this marketing
        $propertyIds = Property::where($ownerColumn, auth()->id())->pluck('id')->all();

        $contacts = [];
        if (! empty($propertyIds)) {
            $contacts = \App\Models\Contact::whereIn('property_id', $propertyIds)->latest()->get();
        }

        return view('marketing.contacts', compact('contacts'));
    }

    // Menampilkan form upload properti baru
    public function create()
    {
        // Pastikan view 'marketing.upload' ada
        return view('marketing.upload');
    }

    // Menyimpan properti baru
    public function store(Request $request)
    {
        // 1. Validasi data
        $validatedData = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:1000000'],
            'luas_tanah' => ['required', 'numeric', 'min:1'],
            'luas_bangunan' => ['required', 'numeric', 'min:1'],
            'gambar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        // 2. Upload gambar ke storage: use stable unique filename and store under public disk
        $file = $request->file('gambar');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $base = Str::slug(substr($validatedData['judul'] ?? 'property', 0, 30));
        $filename = $base . '_' . time() . '_' . uniqid() . '.' . $ext;

        try {
            // Simpan ke disk 'public' di folder 'properties'
            Storage::disk('public')->putFileAs('properties', $file, $filename);
            $imagePath = 'storage/properties/' . $filename; // path stored in DB and used by views

            // Verifikasi file berhasil tersimpan
            if (! Storage::disk('public')->exists('properties/' . $filename)) {
                Log::error('Property image not found after storing', ['filename' => $filename]);
                return Redirect::back()->with('error', 'Gagal menyimpan gambar (file tidak ditemukan setelah upload). Silakan coba lagi.');
            }

            Log::info('Property image stored', ['filename' => $filename, 'path' => $imagePath]);
        } catch (\Exception $e) {
            Log::error('Failed to store property image: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Gagal menyimpan gambar. Silakan coba lagi.');
        }

        // 3. Siapkan data dan simpan Properti (sesuaikan kolom pemilik bila perlu)
        $data = [
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
            'alamat' => $validatedData['alamat'],
            'harga' => $validatedData['harga'],
            'luas_tanah' => $validatedData['luas_tanah'],
            'luas_bangunan' => $validatedData['luas_bangunan'],
            'gambar' => $imagePath, // Simpan path gambar
            'status' => 'pending', // Status awal selalu pending
        ];

        $ownerColumn = Schema::hasColumn('properties', 'marketing_id') ? 'marketing_id' : 'user_id';
        $data[$ownerColumn] = Auth::id();

        $property = Property::create($data);

        // add saved image path to the property model explicitly (in case fillable didn't include it earlier)
        try {
            $property->gambar = $imagePath;
            $property->save();
        } catch (\Exception $e) {
            Log::warning('Failed to save gambar path to property: ' . $e->getMessage());
        }

        // Kirim notifikasi ke admin & ketua bahwa ada properti baru menunggu
        try {
            $admins = User::whereIn('role', ['admin', 'ketua'])->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewProperty($property));
            }
        } catch (\Exception $e) {
            logger()->error('Notify admins failed: ' . $e->getMessage());
        }

        return Redirect::route('marketing.create')
                        ->with('success', 'Properti berhasil diupload. Menunggu persetujuan Admin/Ketua. Gambar tersimpan: ' . $imagePath);
    }

    // Hapus properti milik marketing yang sedang login
    public function destroy(Property $property)
    {
        $ownerColumn = Schema::hasColumn('properties', 'marketing_id') ? 'marketing_id' : 'user_id';

        // Pastikan yang menghapus adalah owner
        if ((int) $property->{$ownerColumn} !== (int) Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hapus file gambar jika ada
        try {
            if ($property->gambar) {
                $file = str_replace('storage/', 'public/', $property->gambar);
                Storage::delete($file);
            }
        } catch (\Exception $e) {
            logger()->warning('Failed to delete property image: ' . $e->getMessage());
        }

        $property->delete();

        return redirect()->route('marketing.properties.index')->with('success', 'Properti berhasil dihapus.');
    }

    // Tandai properti sebagai sudah dikunjungi oleh marketing yang sedang login
    public function markVisited(Property $property)
    {
        $ownerColumn = \Illuminate\Support\Facades\Schema::hasColumn('properties', 'marketing_id') ? 'marketing_id' : 'user_id';

        if ((int) $property->{$ownerColumn} !== (int) Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $property->visited = true;
        $property->save();

        return redirect()->back()->with('success', 'Properti ditandai sebagai sudah dikunjungi.');
    }
}