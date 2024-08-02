<?php

use App\Models\Features;
use App\Models\Plan;
use App\Models\PlansFeatures;
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
        Schema::create('plans_features', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId(PlansFeatures::PLAN_ID)->constrained(Plan::TABLE_NAME)->onDelete('cascade');
            $table->foreignId(PlansFeatures::FEATURES_ID)->constrained(Features::TABLE_NAME)->onDelete('cascade');
            $table->integer(PlansFeatures::COUNT)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_features');
    }
};
