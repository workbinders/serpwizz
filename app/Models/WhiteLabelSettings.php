<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteLabelSettings extends Model
{
    const WHITE_LABEL = 'white_label';
    const DOMAIN_NAME = 'domain_name';
    const AUDIT_REPORT_TITLE = 'audit_report_title';
    const HEADER_BIG_LOGO = 'header_big_logo';
    const HEADER_SMALL_LOGO = 'header_small_logo';
    const FAVICON_ICON = 'favicon_icon';
    const USER_ID     = 'user_id';

    protected $fillable = [
        'WHITE_LABEL' => self::WHITE_LABEL,
        'DOMAIN_NAME' => self::DOMAIN_NAME,
        'AUDIT_REPORT_TITLE' => self::AUDIT_REPORT_TITLE,
        'HEADER_BIG_LOGO' => self::HEADER_BIG_LOGO,
        'HEADER_SMALL_LOGO' => self::HEADER_SMALL_LOGO,
        'FAVICON_ICON' => self::FAVICON_ICON,
        'USER_ID' => self::USER_ID,
    ];
}
