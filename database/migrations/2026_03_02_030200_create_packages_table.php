<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('machine_id')
                ->constrained('machines')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
                // HAPUS ->index()

            $table->foreignId('pic_operator_id')
                ->nullable()
                ->constrained('operators')
                ->cascadeOnUpdate()
                ->nullOnDelete();
                // HAPUS ->index()

            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_price', 15, 2)->default(0);
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};