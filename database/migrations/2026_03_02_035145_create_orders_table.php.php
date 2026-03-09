<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // internal readable number
            $table->string('order_code')->unique();

            // guest access key (unguessable)
            $table->string('access_token', 64)->unique();

            // minimal for sending offer link
            $table->string('customer_email')->index();

            // status lifecycle
            $table->string('status')->default('draft')->index();
            // optional audit fields
            $table->timestamp('sent_at')->nullable()->index();

            // who created (internal user)
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete()
                ->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};