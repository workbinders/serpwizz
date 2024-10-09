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
        Schema::create('leads', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('website', 200);
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('custom_field', 500)->nullable();
            $table->string('checkbox', 50)->nullable();
            $table->integer('score')->default(0);
            $table->unsignedInteger('category')->default(0);
            $table->text('note')->nullable();
            $table->string('language', 100)->nullable();
            $table->timestamp('report_date')->nullable();
            $table->timestamps();


            $table->index('user_id');
            $table->index('website');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
