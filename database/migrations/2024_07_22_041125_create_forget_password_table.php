<?php

use App\Models\ForgetPassword;
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
        Schema::create('forget_passwords', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(ForgetPassword::TOKEN);
            $table->string(ForgetPassword::EMAIL);
            $table->timestamps();
            $table->foreign(ForgetPassword::EMAIL)->references(User::EMAIL)->on(User::TABLE_NAME)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forget_passwords');
    }
};
