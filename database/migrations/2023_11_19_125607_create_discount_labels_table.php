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
        Schema::create('discount_labels', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id');
            $table->string('code');
            $table->string('default_description');
            $table->integer('count')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('precise_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_labels');
    }
};
