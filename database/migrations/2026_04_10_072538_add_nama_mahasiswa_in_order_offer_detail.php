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
        Schema::table('order_offer_details', function (Blueprint $table) {
            $table->string('nama_mahasiswa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_offer_detail', function (Blueprint $table) {
            $table->dropColumn('nama_mahasiswa');
        });
    }
};
