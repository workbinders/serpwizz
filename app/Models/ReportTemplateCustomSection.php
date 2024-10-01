<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplateCustomSection extends Model
{
    use HasFactory;
    const SECTION_NAME = 'section_name';
    const POSITION = 'position';
    const TEXT = 'text';
    const SCRIPT_CODE  = 'script_code';
    const USER_ID   = 'user_id';
    const TOP = 'top';
    const BOTTOM = 'bottom';

    const POSITION_ENUM = [self::TOP, self::BOTTOM];

    protected $fillable = [
        'section_name' => self::SECTION_NAME,
        'position' => self::POSITION,
        'text' => self::TEXT,
        'script_code' => self::SCRIPT_CODE,
        'user_id' => self::USER_ID,
    ];

    protected $table = 'custom_section';
}
