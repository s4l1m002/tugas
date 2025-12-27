<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class DevController extends Controller
{
    // Hanya untuk environment lokal: pastikan akun default ada
    public function ensureUsers()
    {
        if (! app()->environment('local') && ! config('app.debug')) {
            abort(404);
        }

        $defaults = [
            ['email' => 'admin@example.test', 'name' => 'Admin Tester', 'role' => 'admin'],
            ['email' => 'marketing@example.test', 'name' => 'Marketing Tester', 'role' => 'marketing'],
            ['email' => 'pelanggan@example.test', 'name' => 'Pelanggan Tester', 'role' => 'pelanggan'],
            ['email' => 'ketua@example.test', 'name' => 'Ketua Tester', 'role' => 'ketua'],
        ];

        foreach ($defaults as $d) {
            User::updateOrCreate([
                'email' => $d['email']
            ], [
                'name' => $d['name'],
                'password' => Hash::make('password123'),
                'role' => $d['role']
            ]);
        }

        return response()->json(['ok' => true, 'message' => 'Default users ensured (password: password123)']);
    }

    public function dedupeProperties()
    {
        if (! app()->environment('local') && ! config('app.debug')) {
            abort(404);
        }

        // Group by title and keep the earliest id, delete others
        $dupes = \DB::table('properties')
            ->select('judul', \DB::raw('MIN(id) as keep_id'))
            ->groupBy('judul')
            ->get();

        $keeps = $dupes->pluck('keep_id')->all();

        $deleted = 0;
        $all = \DB::table('properties')->pluck('id');
        foreach ($all as $id) {
            if (! in_array($id, $keeps)) {
                \DB::table('properties')->where('id', $id)->delete();
                $deleted++;
            }
        }

        return response()->json(['ok' => true, 'deleted' => $deleted]);
    }

    /**
     * Fetch an external image URL and save it into storage/app/public/properties
     * then update the property's `gambar` column to 'storage/properties/filename'.
     * Local-use only.
     */
    public function fetchImageForProperty(Request $request)
    {
        if (! app()->environment('local') && ! config('app.debug')) {
            abort(404);
        }

        $data = $request->validate([
            'property_id' => 'required|integer|exists:properties,id',
            'url' => 'required|url',
        ]);

        $property = Property::find($data['property_id']);

        try {
            $resp = Http::timeout(15)->get($data['url']);
            if (! $resp->successful()) {
                return response()->json(['ok' => false, 'message' => 'Failed to download image, remote returned '.$resp->status()], 400);
            }

            $content = $resp->body();
            // try to determine extension
            $ext = null;
            $ct = $resp->header('Content-Type');
            if ($ct) {
                if (str_contains($ct, 'jpeg')) $ext = 'jpg';
                elseif (str_contains($ct, 'png')) $ext = 'png';
                elseif (str_contains($ct, 'gif')) $ext = 'gif';
            }
            if (! $ext) {
                $ext = pathinfo(parse_url($data['url'], PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            }

            $filename = 'img_' . uniqid() . '.' . $ext;
            $path = 'public/properties/' . $filename;
            Storage::put($path, $content);

            // update model to point to storage path
            $property->gambar = 'storage/properties/' . $filename;
            $property->save();

            return response()->json(['ok' => true, 'filename' => $filename, 'path' => $property->gambar]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Development helper: resend the NewContact notification for the latest contact.
     * If no contact exists, create a quick test contact for the first property.
     */
    public function resendLastContact(Request $request)
    {
        if (! app()->environment('local') && ! config('app.debug')) {
            abort(404);
        }

        // require auth to perform this action in dev
        if (! $request->user()) {
            abort(403);
        }

        // find latest contact row
        $row = \DB::table('contacts')->orderBy('id', 'desc')->first();

        if (! $row) {
            // create a simple contact for the first property as test
            $property = Property::first();
            if (! $property) {
                return back()->with('error', 'No properties found to create a test contact.');
            }

            $payload = [
                'property_id' => $property->id,
                'marketing_id' => $property->marketing_id ?? $property->user_id ?? null,
                'pelanggan_id' => $request->user()->id,
                'pesan' => 'Test contact created by dev resend button',
                'status' => 'new',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $id = \DB::table('contacts')->insertGetId($payload);
            $row = \DB::table('contacts')->where('id', $id)->first();
        }

        // Build Contact model instance
        $contact = \App\Models\Contact::find($row->id) ?? new \App\Models\Contact();
        if (! $contact->exists) {
            $contact->exists = true;
            $contact->setRawAttributes((array) $row, true);
        }

        // Try to find property & recipient
        $property = Property::find($contact->property_id);
        if (! $property) {
            return back()->with('error', 'Property for contact not found');
        }

        $recipient = $property->marketing ?? $property->owner();
        if (! $recipient) {
            return back()->with('error', 'No recipient/marketing found for the property');
        }

        try {
            $recipient->notify(new \App\Notifications\NewContact($contact));
        } catch (\Exception $e) {
            logger()->error('Dev resend notify failed: ' . $e->getMessage());
            return back()->with('error', 'Kirim notif gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Notifikasi NewContact terkirim ulang ke marketing.');
    }
}
