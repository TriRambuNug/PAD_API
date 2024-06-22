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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->string('order_code')->unique();
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('description')->nullable()->comment('note');
            $table->string('status')->default('pending')->comment('pending, done, fail');
            $table->string('category')->comment('Top up, Transaction, Withdrawal, Transfer');
            $table->bigInteger('subtotal')->default(0);
            $table->integer('royalty_fee')->default(0);
            $table->integer('royalty_commitment')->default(0);
            $table->integer('admin_fee')->default(0);
            $table->bigInteger('gross_amount')->default(0);
            $table->string('methode')->default('DUWIT')->comment('BRI, BNI, BCA, dll');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['transaction_code', 'order_code', 'name']);
            $table->index(['category', 'methode','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
