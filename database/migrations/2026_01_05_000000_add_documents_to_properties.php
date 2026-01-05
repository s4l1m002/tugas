<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('properties')) return;

        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'imb_complete')) {
                $table->boolean('imb_complete')->default(false)->after('status');
            }
            if (! Schema::hasColumn('properties', 'pbb_complete')) {
                $table->boolean('pbb_complete')->default(false)->after('imb_complete');
            }
            if (! Schema::hasColumn('properties', 'sertifikat_complete')) {
                $table->boolean('sertifikat_complete')->default(false)->after('pbb_complete');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('properties')) return;

        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'sertifikat_complete')) {
                $table->dropColumn('sertifikat_complete');
            }
            if (Schema::hasColumn('properties', 'pbb_complete')) {
                $table->dropColumn('pbb_complete');
            }
            if (Schema::hasColumn('properties', 'imb_complete')) {
                $table->dropColumn('imb_complete');
            }
        });
    }
};
