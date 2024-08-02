<?php

use App\Models\ReportTemplate;
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
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string(ReportTemplate::REPORT_HEADER_TEXT)->nullable();
            $table->string(ReportTemplate::COMPANY_NAME);
            $table->string(ReportTemplate::COMPANY_EMAIL)->nullable();
            $table->string(ReportTemplate::COMPANY_WEBSITE)->nullable();
            $table->string(ReportTemplate::COMPANY_PHONE)->nullable();
            $table->string(ReportTemplate::COMPANY_ADDRESS);
            $table->string(ReportTemplate::COMPANY_LOGO)->nullable();
            $table->string(ReportTemplate::CUSTOM_TITLE)->nullable();
            $table->boolean(ReportTemplate::CUSTOM_TITLE_STATUS)->default(0);
            $table->foreignId(ReportTemplate::USER_ID)->constrained(User::TABLE_NAME)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_templates');
    }
};
