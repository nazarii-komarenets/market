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

            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('product_id');

            $table->string('client_phone');
            $table->string('client_address');
            $table->text('note');

            $table->foreign('status_id')
                ->references('id')
                ->on('order_statuses');

            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

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
