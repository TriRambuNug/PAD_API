<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('account_code')->unique();
            $table->string('fullname');
            $table->string('phone', 13)->unique();
            $table->string('password');
            $table->string('pin', 6)->nullable();
            $table->string('avatar')->nullable();
            $table->string('role')->default('customer')->comment('customer, partner_manager, partner_staff, admin_manager, admin_staff');
            $table->string('type')->default('regular');
            $table->string('email')->nullable();
            $table->string('status')->default('active')->comment('active, block');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Menambahkan indeks dengan prefiks setelah tabel dibuat
        DB::statement('ALTER TABLE users ADD INDEX users_account_code_fullname_phone_password_created_at_index (account_code(10), fullname(10), phone, password(10), created_at)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
