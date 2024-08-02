<?php

use App\Models\Plan;
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
        Schema::create('plans', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(Plan::NAME);
            $table->string(Plan::SLUG);
            $table->float(Plan::MONTHLY_PRICE, 2);
            $table->float(Plan::ANNAL_PRICE, 2);
            $table->string(Plan::DESCRIPTION)->nullable();
            $table->boolean(Plan::HIGHLIGHT);
            $table->integer(Plan::ORDERING)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
