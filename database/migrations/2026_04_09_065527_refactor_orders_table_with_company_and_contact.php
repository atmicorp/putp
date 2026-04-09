<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ➕ Tambah kolom dulu (di luar drop)
        if (!Schema::hasColumn('orders', 'company_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('company_id')
                      ->nullable()
                      ->constrained()
                      ->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('orders', 'contact_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('contact_id')
                      ->nullable()
                      ->constrained()
                      ->cascadeOnDelete();
            });
        }

        // ❌ Hapus kolom lama
        Schema::table('orders', function (Blueprint $table) {

            if (Schema::hasColumn('orders', 'customer_name')) {
                $table->dropColumn('customer_name');
            }

            if (Schema::hasColumn('orders', 'customer_slug')) {
                $table->dropColumn('customer_slug');
            }

            if (Schema::hasColumn('orders', 'customer_email')) {
                $table->dropColumn('customer_email');
            }
        });
    }

    public function down(): void
    {
        // ➕ Balikin kolom lama
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable();
            }

            if (!Schema::hasColumn('orders', 'customer_slug')) {
                $table->string('customer_slug')->nullable();
            }

            if (!Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->nullable();
            }
        });

        // ❌ Hapus relasi baru
        if (Schema::hasColumn('orders', 'company_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropConstrainedForeignId('company_id');
            });
        }

        if (Schema::hasColumn('orders', 'contact_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropConstrainedForeignId('contact_id');
            });
        }
    }
};