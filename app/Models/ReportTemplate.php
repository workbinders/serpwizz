<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReportTemplate extends Model
{
    const REPORT_HEADER_TEXT = 'report_header_text';
    const COMPANY_NAME = 'company_name';
    const COMPANY_EMAIL = 'company_email';
    const COMPANY_WEBSITE = 'company_website';
    const COMPANY_PHONE = 'company_phone';
    const COMPANY_ADDRESS = 'company_address';
    const CUSTOM_TITLE = 'custom_title';
    const USER_ID     = 'user_id';
    const CUSTOM_TITLE_STATUS = 'custom_title_status';
    const COMPANY_LOGO = 'company_logo';

    protected $fillable = [
        'REPORT_HEADER_TEXT' => self::REPORT_HEADER_TEXT,
        'COMPANY_NAME' => self::COMPANY_NAME,
        'COMPANY_EMAIL' => self::COMPANY_EMAIL,
        'COMPANY_WEBSITE' => self::COMPANY_WEBSITE,
        'COMPANY_PHONE' => self::COMPANY_PHONE,
        'COMPANY_ADDRESS' => self::COMPANY_ADDRESS,
        'CUSTOM_TITLE'   => self::CUSTOM_TITLE,
        'USER_ID'   => self::USER_ID,
        'CUSTOM_TITLE_STATUS' => self::CUSTOM_TITLE_STATUS,
        'COMPANY_LOGO' => self::COMPANY_LOGO,

    ];

    protected $table = 'report_templates';

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
