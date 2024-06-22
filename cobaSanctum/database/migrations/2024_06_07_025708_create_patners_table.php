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
        Schema::create('patners', function (Blueprint $table) {
            $table->id();
            $table->string('patner_code')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('picture');
            $table->longText('address')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('email')->nullable();
            $table->string('type')->comment('merchant, institution');
            $table->string('status')->comment('active, block');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patner_code', 'name', 'phone','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patners');
    }
};
