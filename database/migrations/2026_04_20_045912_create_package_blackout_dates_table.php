<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package_blackout_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')
                  ->constrained('packages')
                  ->cascadeOnDelete();
            $table->date('date');
            $table->string('note', 255)->nullable(); // opsional: alasan full
            $table->timestamps();

            $table->unique(['package_id', 'date']); // no duplicate date per package
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_blackout_dates');
    }
};