<?php

use App\Models\ReportTemplateCustomSection;
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
        Schema::create('custom_section', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(ReportTemplateCustomSection::SECTION_NAME);
            $table->enum(ReportTemplateCustomSection::POSITION, ReportTemplateCustomSection::POSITION_ENUM);
            $table->foreignId(ReportTemplateCustomSection::USER_ID)->constrained(User::TABLE_NAME)->onDelete('cascade');
            $table->string(ReportTemplateCustomSection::TEXT)->nullable();
            $table->text(ReportTemplateCustomSection::SCRIPT_CODE)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_section');
    }
};
