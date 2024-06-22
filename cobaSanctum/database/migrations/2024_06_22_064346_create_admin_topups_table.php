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
        Schema::create('admin_topups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->unsignedBigInteger('pocket_id');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->bigInteger('amount');
            $table->string('proff')->nullable()->comment('proff transfer rekening bank CN photo');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['admin_id', 'transaction_id', 'pocket_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_topups');
    }
};
