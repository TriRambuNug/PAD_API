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
        //  Ini tabel untuk menghubungkan nasabah dengan pocketnya
        Schema::create('pocket_users', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('pocket_id');
            $table->foreign('pocket_id')->references('id')->on('pockets');
            $table->string('level', 10)->comment('owner, member');
            $table->timestamps();
            $table->index(['user_id', 'pocket_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pocket_users');
    }
};
