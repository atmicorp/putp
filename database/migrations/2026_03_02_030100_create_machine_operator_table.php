<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('machine_operator', function (Blueprint $table) {
            $table->id();

            $table->foreignId('machine_id')
                ->constrained('machines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('operator_id')
                ->constrained('operators')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();

            // mencegah duplikat pasangan machine-operator
            $table->unique(['machine_id', 'operator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_operator');
    }
};