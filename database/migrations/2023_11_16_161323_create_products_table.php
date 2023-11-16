<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('ah_id');
            $table->string('title');
            $table->string('sales_unit_size');
            $table->string('unit_price_description');
            $table->decimal('price');
            $table->enum('order_availability_status', ['IN_ASSORTMENT', 'OUT_ASSORTMENT', 'UNKNOWN']);
            $table->string('main_category');
            $table->string('sub_category');
            $table->string('brand');
            $table->string('shop_type');
            $table->boolean('available_online');
            $table->boolean('is_previously_bought');
            $table->text('description_highlights');
            $table->text('property_icons');
            $table->char('nutriscore', 1);
            $table->boolean('nix18');
            $table->boolean('is_stapel_bonus');
            $table->text('extra_description');
            $table->boolean('is_orderable');
            $table->boolean('is_infinite_bonus');
            $table->boolean('is_sample');
            $table->boolean('is_sponsored');
            $table->boolean('is_virtualBundle');
            $table->text('discount_labelss');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
