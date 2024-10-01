<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class whiteLabelSettings extends Model
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
    protected function headerBigLogo(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value === null) {
                    return null;
                }
                return filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/' . $value);
            },
            set: function (string|UploadedFile|null $value) {
                if ($value instanceof UploadedFile) {
                    $user = Auth::user();
                    return $value->storeAs('images/' . $user->slug, 'header_big_logo', 'public') ?: null;
                }

                return $value;
            }
        );
    }
    protected function headerSmallLogo(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value === null) {
                    return null;
                }
                return filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/' . $value);
            },
            set: function (string|UploadedFile|null $value) {
                if ($value instanceof UploadedFile) {
                    $user = Auth::user();
                    return $value->storeAs('images/' . $user->slug, 'header_small_Logo.jpg', 'public') ?: null;
                }

                return $value;
            }
        );
    }
    protected function faviconIcon(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value === null) {
                    return null;
                }
                return filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/' . $value);
            },
            set: function (string|UploadedFile|null $value) {
                if ($value instanceof UploadedFile) {
                    $user = Auth::user();
                    return $value->storeAs('images/' . $user->slug, 'favicon_icon.jpg', 'public') ?: null;
                }

                return $value;
            }
        );
    }
}
