<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_offers', function (Blueprint $table) {
            $table->string('offer_file_path')->nullable()->after('terms');
            $table->string('invoice_file_path')->nullable()->after('offer_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('order_offers', function (Blueprint $table) {
            $table->dropColumn(['offer_file_path', 'invoice_file_path']);
        });
    }
};

