<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK (Tidak Perlu Login) ---
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/property/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/contact/{property}', [ContactController::class, 'store'])->name('contact.store');

// --- 2. AUTHENTIKASI (LOGIN, REGISTER, & LOGOUT) ---

// Route ini di-group dengan middleware 'guest' agar tidak bisa diakses saat sudah login
Route::group(['middleware' => 'guest'], function () {
    
    // LOGIN
    Route::get('/login', [LoginController::class, 'create'])->name('login');    
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    // REGISTER
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});
Route::get('/home', function () {
    return redirect()->route('properties.index');
});
// Route Logout (membutuhkan login)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');


// --- 3. KELOMPOK ROUTE YANG MEMBUTUHKAN LOGIN ('auth' middleware) ---
Route::middleware('auth')->group(function () {
    
    // Dashboard Default
    Route::get('/dashboard', function () {
        // Logika redirect sesuai role
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.pending');
        } elseif (Auth::user()->hasRole('marketing')) {
            return redirect()->route('marketing.properties.index');
        }
        // Jika hanya user biasa, arahkan ke dashboard/home
        // PERBAIKAN KECIL: Memanggil view 'home' (tanpa .blade.php)
        return view('home'); 
    })->name('dashboard');

    // --- A. ROUTE KHUSUS MARKETING ---
    // Gate 'isMarketing' akan memproteksi semua route di dalam group ini
    Route::middleware('can:isMarketing')->prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/', [MarketingController::class, 'index'])->name('properties.index');
        Route::get('/contacts', [MarketingController::class, 'contacts'])->name('contacts.index');
        Route::get('/create', [MarketingController::class, 'create'])->name('create');
        Route::post('/', [MarketingController::class, 'store'])->name('store');
        Route::delete('/{property}', [MarketingController::class, 'destroy'])->name('destroy');
        Route::post('/{property}/visited', [MarketingController::class, 'markVisited'])->name('mark.visited');
        Route::get('/profile', [\App\Http\Controllers\Auth\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Auth\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\Auth\ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    // Marketing: aksi pada kontak (tandai sudah dihubungi)
    Route::post('/contacts/{contact}/mark-contacted', [ContactController::class, 'markContacted'])->name('contact.mark_contacted')->middleware('can:isMarketing');

    // Notifikasi pengguna
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    // Admin: API endpoint to get pending count (for live update)
    Route::get('/admin/pending-count', [\App\Http\Controllers\AdminController::class, 'pendingCount'])->name('admin.pending_count');
    
    // --- B. ROUTE KHUSUS ADMIN/KETUA ---
    // Akses untuk admin atau ketua. Gate 'isAdmin' sebelumnya mencegah ketua.
    Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/pending', [AdminController::class, 'pendingProperties'])->name('pending');
        Route::post('/approve/{property}', [AdminController::class, 'approve'])->name('approve');
        Route::post('/reject/{property}', [AdminController::class, 'reject'])->name('reject');
        
        // ROUTE TRANSAKSI
        Route::get('/transaction/create/{property}', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transaction/{property}', [TransactionController::class, 'store'])->name('transactions.store');
        // Admin confirm transaction (mark as paid)
        Route::post('/transaction/{transaction}/confirm', [TransactionController::class, 'adminConfirm'])->name('transactions.confirm.admin');

        // ROUTE LAPORAN KHUSUS KETUA
        Route::middleware('can:isKetuaOrAdmin')->prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\ReportController::class, 'index'])->name('index');
            Route::get('/transactions', [\App\Http\Controllers\ReportController::class, 'transactions'])->name('transactions');
            Route::get('/commissions', [\App\Http\Controllers\ReportController::class, 'commissions'])->name('commissions');
            Route::get('/visits', [\App\Http\Controllers\ReportController::class, 'visits'])->name('visits');
            Route::get('/documents', [\App\Http\Controllers\ReportController::class, 'documents'])->name('documents');
            Route::get('/taxes', [\App\Http\Controllers\ReportController::class, 'taxes'])->name('taxes');
            // Printable versions
            Route::get('/transactions/print', [\App\Http\Controllers\ReportController::class, 'printTransactions'])->name('transactions.print');
        });
    });

    // Pelanggan: purchase routes (setuju -> pilih metode pembayaran)
    Route::get('/property/{property}/purchase', [TransactionController::class, 'purchaseForm'])->name('transactions.purchase.form');
    Route::post('/property/{property}/purchase', [TransactionController::class, 'purchase'])->name('transactions.purchase');
    // Pelanggan: lihat transaksi milik sendiri
    Route::get('/my-transactions', [TransactionController::class, 'myTransactions'])->name('transactions.my');
    // Pelanggan: form buat transaksi (pilih property + metode pembayaran)
    Route::get('/transactions/create', [TransactionController::class, 'createForCustomer'])->name('transactions.create.form');
    Route::post('/transactions', [TransactionController::class, 'storeCustomer'])->name('transactions.store.customer');
    // Customer confirm payment (for cash)
    Route::post('/transactions/{transaction}/confirm', [TransactionController::class, 'customerConfirm'])->name('transactions.confirm.customer');
});

// Development helper: tambahkan default users (lokal saja)
Route::get('/dev/ensure-users', [DevController::class, 'ensureUsers'])->name('dev.ensure_users');
Route::get('/dev/dedupe-properties', [DevController::class, 'dedupeProperties'])->name('dev.dedupe_properties');
Route::post('/dev/fetch-image', [DevController::class, 'fetchImageForProperty'])->name('dev.fetch_image');
Route::post('/dev/resend-last-contact', [DevController::class, 'resendLastContact'])->name('dev.resend_last_contact')->middleware('auth');