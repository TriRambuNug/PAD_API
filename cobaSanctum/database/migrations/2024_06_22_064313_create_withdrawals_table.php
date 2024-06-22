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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pocket_id');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->string('vendor');
            $table->string('name');
            $table->string('account_number');
            $table->bigInteger('amount');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('status')->default('pending')->comment('pending, done, reject');
            $table->string('proff')->nullable()->comment('proff transfer photo');
            $table->text('comment')->nullable()->comment('reject comment');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['pocket_id', 'transaction_id']);
            $table->index(['name', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
