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
            $table->id();
            $table->integer('ah_id');
            $table->string('title');
            $table->string('sales_unit_size')->nullable();
            $table->string('unit_price_description')->nullable();
            $table->decimal('price')->nullable();
            $table->enum('order_availability_status', ['IN_ASSORTMENT', 'OUT_ASSORTMENT', 'UNKNOWN'])->nullable();
            $table->string('main_category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('brand')->nullable();
            $table->string('shop_type')->nullable();
            $table->boolean('available_online');
            $table->boolean('is_previously_bought');
            $table->text('description_highlights')->nullable();
            $table->text('property_icons')->nullable();
            $table->char('nutriscore', 1)->nullable()->nullable();
            $table->boolean('nix18');
            $table->boolean('is_stapel_bonus');
            $table->text('extra_description')->nullable();
            $table->boolean('is_bonus');
            $table->boolean('is_orderable');
            $table->boolean('is_infinite_bonus');
            $table->boolean('is_sample');
            $table->boolean('is_sponsored');
            $table->boolean('is_virtualBundle');
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
