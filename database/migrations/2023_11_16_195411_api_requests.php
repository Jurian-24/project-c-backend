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
        Schema::create('api_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->string('api_key');
            $table->string('end_point');
            $table->enum('http_method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']);
            $table->text('request_body');
            $table->text('query_paramaters');
            $table->text('headers')->nullable();
            $table->integer('response_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
