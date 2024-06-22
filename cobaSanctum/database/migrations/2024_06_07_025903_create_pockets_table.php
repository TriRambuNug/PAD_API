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
        Schema::create('pockets', function (Blueprint $table) {
            $table->id();
            $table->string('pocket_code')->unique();
            $table->string('name');
            $table->string('picture');
            $table->bigInteger('balance')->default(0);
            $table->integer('limit')->default(0);
            $table->bigInteger('target')->default(0);
            $table->boolean('ishide')->default(false);
            $table->string('color')->nullable()->default('#FFFFFF');
            $table->string('status')->default('active')->comment('active, block');
            $table->string('type')->comment('company, main, saving, wallet, joint_saving, joint_wallet');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pockets');
    }
};
