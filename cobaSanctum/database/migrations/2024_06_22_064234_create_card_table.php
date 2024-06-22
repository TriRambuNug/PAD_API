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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('idcard')->unique();
            $table->string('card_code')->unique();
            $table->string('name');
            $table->unsignedBigInteger('pocket_id');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->string('cvv',3);
            $table->string('status')->comment('active, block');
            $table->string('class')->default('regular');
            $table->dateTime('expired_at', $precision = 0);
            $table->string('front_view')->nullable();
            $table->string('behind_view')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name', 'pocket_id', 'card_code']);
            $table->index(['created_at']);
            $table->index(['idcard']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
