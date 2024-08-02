<?php

use App\Models\Features;
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
        Schema::create('features', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(Features::NAME);
            $table->string(Features::SLUG);
            $table->string(Features::DESCRIPTION)->nullable();
            $table->string(Features::VALUE);
            $table->integer(Features::ORDERING)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
