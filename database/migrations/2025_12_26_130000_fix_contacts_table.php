<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration is idempotent: it only adds columns that are missing.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('contacts')) {
            // If table doesn't exist at all, create it with expected columns.
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('property_id')->nullable();
                $table->unsignedBigInteger('marketing_id')->nullable();
                $table->unsignedBigInteger('pelanggan_id')->nullable();
                $table->text('pesan')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
            return;
        }

        if (! Schema::hasColumn('contacts', 'property_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->unsignedBigInteger('property_id')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('contacts', 'marketing_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->unsignedBigInteger('marketing_id')->nullable()->after('property_id');
            });
        }

        if (! Schema::hasColumn('contacts', 'pelanggan_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->unsignedBigInteger('pelanggan_id')->nullable()->after('marketing_id');
            });
        }

        if (! Schema::hasColumn('contacts', 'pesan')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->text('pesan')->nullable()->after('pelanggan_id');
            });
        }

        if (! Schema::hasColumn('contacts', 'status')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('pesan');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('contacts')) {
            return;
        }

        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('contacts', 'pesan')) {
                $table->dropColumn('pesan');
            }
            if (Schema::hasColumn('contacts', 'pelanggan_id')) {
                $table->dropColumn('pelanggan_id');
            }
            if (Schema::hasColumn('contacts', 'marketing_id')) {
                $table->dropColumn('marketing_id');
            }
            if (Schema::hasColumn('contacts', 'property_id')) {
                $table->dropColumn('property_id');
            }
        });
    }
};
