<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');        // nama pegawai
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // TTD (path file gambar)
            $table->string('signature_path')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // optional biar tidak duplicate email dalam 1 PT
            $table->unique(['company_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
