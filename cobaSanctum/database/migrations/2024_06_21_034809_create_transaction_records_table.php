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
        Schema::create('transaction_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->unsignedBigInteger('pocket_id');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->bigInteger('amount');
            $table->string('type')->comment('income, outcome');
            $table->string('category')->comment('Top up, Transaction, Withdrawal, Transfer');
            // $table->string('status')->default('pending')->comment('pending, done, fail');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'transaction_id', 'pocket_id']);
            $table->index(['category', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_records');
    }
};
