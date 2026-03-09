<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_offer_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_offer_id');
            $table->unsignedBigInteger('package_id');

            $table->unsignedInteger('qty')->default(1);
            $table->decimal('price', 15, 2)->default(0);

            $table->timestamps();

            $table->unique(['order_offer_id', 'package_id'], 'uq_offer_package');

            // FK names explicit (unik & jelas)
            $table->foreign('order_offer_id', 'fk_offer_details_offer')
                ->references('id')
                ->on('order_offers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('package_id', 'fk_offer_details_package')
                ->references('id')
                ->on('packages')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_offer_details');
    }
};