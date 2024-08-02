<?php

use App\Models\User;
use App\Models\WhiteLabelSettings;
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
        Schema::create('white_label_settings', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->boolean(WhiteLabelSettings::WHITE_LABEL)->default(0);
            $table->string(WhiteLabelSettings::DOMAIN_NAME);
            $table->string(WhiteLabelSettings::AUDIT_REPORT_TITLE);
            $table->foreignId(WhiteLabelSettings::USER_ID)->constrained(User::TABLE_NAME)->onDelete('cascade');
            $table->string(WhiteLabelSettings::HEADER_BIG_LOGO)->nullable();
            $table->string(WhiteLabelSettings::HEADER_SMALL_LOGO)->nullable();
            $table->string(WhiteLabelSettings::FAVICON_ICON)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('white_label_settings');
    }
};
