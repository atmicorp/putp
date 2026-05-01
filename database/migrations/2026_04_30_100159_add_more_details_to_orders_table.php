<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('tujuan_pengujian')->nullable()->after('created_by');
            $table->date('waktu_diharapkan')->nullable()->after('tujuan_pengujian');
            $table->text('keterangan_tambahan')->nullable()->after('waktu_diharapkan');
            $table->date('waktu_pelaksanaan')->nullable()->after('keterangan_tambahan');
            $table->string('lokasi_pelaksanaan')->nullable()->after('waktu_pelaksanaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'tujuan_pengujian',
                'waktu_diharapkan',
                'keterangan_tambahan',
                'waktu_pelaksanaan',
                'lokasi_pelaksanaan',
            ]);
        });
    }
};
