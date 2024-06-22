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
        //  Ini tabel untuk menghubungkan patner dengan pocketnya
        Schema::create('pocket_patners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pocket_id');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->unsignedBigInteger('patner_id');
            $table->foreign('patner_id')->references('id')->on('patners');
            $table->timestamps();
            $table->index(['patner_id', 'pocket_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pocket_patners');
    }
};
