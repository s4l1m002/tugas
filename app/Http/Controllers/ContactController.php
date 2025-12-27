<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Notifications\NewContact;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MarketingContacted;
use App\Models\User;

class ContactController extends Controller
{
    /**
     * Menyimpan pesan kontak yang dikirim dari halaman detail properti.
     */
    public function store(Request $request, Property $property)
    {
        // Form kontak hanya tersedia untuk pelanggan yang login (view sudah membatasi)
        $user = $request->user();
        if (! $user || $user->role !== 'pelanggan') {
            return back()->with('error', 'Silakan login sebagai Pelanggan untuk mengajukan permintaan kontak.');
        }

        // Validasi pesan opsional
        $pesan = null;
        if ($request->filled('pesan')) {
            $request->validate(['pesan' => 'string|min:10']);
            $pesan = $request->input('pesan');
        }


        // Simpan pesan kontak ke database. Different dev DBs may have different
        // contact table names/columns (legacy 'tabel_contacts' vs 'contacts'),
        // so detect the actual table and its columns and insert accordingly.
        $table = null;
        if (\Schema::hasTable('contacts')) {
            $table = 'contacts';
        } elseif (\Schema::hasTable('tabel_contacts')) {
            $table = 'tabel_contacts';
        }

        if (! $table) {
            return back()->with('error', 'Contact table not found in database.');
        }

        $cols = \Schema::getColumnListing($table);
        $payload = [];
        if (in_array('property_id', $cols)) {
            $payload['property_id'] = $property->id;
        }
        if (in_array('marketing_id', $cols)) {
            $payload['marketing_id'] = $property->marketing_id ?? $property->user_id ?? null;
        }
        if (in_array('pelanggan_id', $cols)) {
            $payload['pelanggan_id'] = $user->id;
        }
        if (in_array('nama_pengirim', $cols)) {
            $payload['nama_pengirim'] = $user->name;
        }
        if (in_array('email_pengirim', $cols)) {
            $payload['email_pengirim'] = $user->email;
        }
        if (in_array('pesan', $cols)) {
            $payload['pesan'] = $pesan;
        }
        if (in_array('status', $cols)) {
            $payload['status'] = 'new';
        }

        if (empty($payload)) {
            return back()->with('error', 'No matching contact columns found to save.');
        }

        // Insert and retrieve inserted row
        $id = \DB::table($table)->insertGetId($payload);
        $row = \DB::table($table)->where('id', $id)->first();

        // Build a Contact model instance for notifications
        $contact = new Contact();
        $contact->exists = true;
        $contact->setRawAttributes((array) $row, true);

        // Kirim notifikasi database ke marketing/owner (jika ada).
        // Use relationship or fallback owner() helper (handles marketing_id or user_id).
        $recipient = $property->marketing ?? $property->owner();
        if ($recipient) {
            try {
                $recipient->notify(new NewContact($contact));
            } catch (\Exception $e) {
                logger()->error('Notify marketing failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Pesan Anda berhasil terkirim kepada marketing properti ini.');
    }

    // Mark a contact as contacted by marketing (marketing action)
    public function markContacted(Request $request, Contact $contact)
    {
        // hanya marketing yang boleh memanggil ini
        if (! $request->user() || $request->user()->role !== 'marketing') {
            abort(403);
        }

        $contact->status = 'contacted';
        $contact->save();

        // Notify pelanggan that their request was created (optional)
        try {
            $pelanggan = $contact->pelanggan;
            if ($pelanggan) {
                $pelanggan->notify(new MarketingContacted($contact));
            }
        } catch (\Exception $e) {
            logger()->error('Notify pelanggan on create failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Kontak ditandai sudah dihubungi.');
    }

    /**
     * Catatan: Untuk melihat pesan kontak, fungsionalitasnya
     * biasanya ada di MarketingController (untuk melihat pesan yang masuk ke dia)
     * atau AdminController (untuk melihat semua pesan).
     */
}