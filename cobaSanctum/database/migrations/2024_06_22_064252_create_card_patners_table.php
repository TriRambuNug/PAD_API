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
        Schema::create('card_patners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('card_id');
            $table->foreign('card_id')->references('id')->on('cards');
            $table->unsignedBigInteger('patner_id');
            $table->foreign('patner_id')->references('id')->on('patners');
            $table->string('addition_code')->nullable()->comment('like NIP, NIK, NISN, dll');
            $table->integer('royalty_commitment')->default(0);
            $table->timestamps();
            $table->index(['name']);
            $table->index(['card_id', 'patner_id']);
            $table->index(['addition_code']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_patners');
    }
};
