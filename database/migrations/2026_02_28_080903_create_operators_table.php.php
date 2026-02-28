<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->id();

            // 1-1 ke users
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Optional fields (sesuaikan kebutuhan)
            $table->string('employee_code')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // pastikan 1 user hanya punya 1 operator profile
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};