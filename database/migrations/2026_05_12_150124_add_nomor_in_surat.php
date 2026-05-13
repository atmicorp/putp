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
        Schema::table('surat_pks', function (Blueprint $table) {
            $table->string('nomor')->after('order_id');
        });

        Schema::table('surat_mou', function (Blueprint $table) {
            $table->string('nomor')->after('order_id');
        });

        Schema::table('surat_kesanggupan', function (Blueprint $table) {
            $table->string('nomor')->after('order_id');
        });

        Schema::table('surat_bap', function (Blueprint $table) {
            $table->string('nomor')->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_pks', function (Blueprint $table) {
            $table->dropColumn('nomor');
        });

        Schema::table('surat_mou', function (Blueprint $table) {
            $table->dropColumn('nomor');
        });

        Schema::table('surat_kesanggupan', function (Blueprint $table) {
            $table->dropColumn('nomor');
        });

        Schema::table('surat_bap', function (Blueprint $table) {
            $table->dropColumn('nomor');
        });
        }
};
