<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(User::FIRST_NAME);
            $table->string(User::LAST_NAME);
            $table->string(User::EMAIL)->unique()->index();
            $table->string(User::SLUG)->unique();
            $table->string(User::PASSWORD);
            $table->enum(User::ROLE, User::ROLE_ENUM)->default(User::USER);
            $table->string(User::PROFILE_IMAGE)->nullable();
            $table->string(User::LANGUAGE)->default(config('serpwizz.lang')['en']);
            $table->string(User::ACCOUNT_NAME)->unique()->index();
            $table->string(User::REFERRAL_CODE)->nullable();
            $table->enum(User::STATUS, User::STATUS_ENUM)->default(User::PENDING)->index();
            $table->string(User::GOOGLE_USER_ID)->nullable();
            $table->string(User::LINKEDIN_USER_ID)->nullable();
            $table->string(User::LAST_LOGIN_IP)->nullable();
            $table->string(User::LAST_LOGIN_CLIENT)->nullable();
            $table->timestamp(User::LAST_LOGIN)->nullable();
            $table->string(User::VERIFICATION_TOKEN, 200)->nullable();
            $table->rememberToken();
            $table->timestamps();
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
