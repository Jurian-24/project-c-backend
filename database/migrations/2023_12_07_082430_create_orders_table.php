<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basket_id')->foreign('id')->on('baskets');
            $table->unsignedBigInteger('invoice_id')->foreign('id')->on('invoices');
            $table->integer('total_price')->default(0);
            $table->string('status')->default('pending');
            $table->string('payment_method')->default('IDEAL');
            $table->string('payment_status')->default('pending');
            $table->unsignedBigInteger('company_id')->foreign('id')->on('companies');
            $table->enum('delivery_service', ['Albert Heijn', 'De Buurtboer'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
