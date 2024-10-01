<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const TABLE_NAME           = 'users';
    const SINGLE_NAME          = 'user';
    const TOKEN                = 'token';


    //Table fields
    const FIRST_NAME           = 'first_name';
    const LAST_NAME            = 'last_name';
    const EMAIL                = 'email';
    const PASSWORD             = 'password';
    const ROLE                 = 'role';
    const PROFILE_IMAGE        = 'profile_image';
    const STATUS               = 'status';
    const LANGUAGE             = 'language';
    const LAST_LOGIN           = 'last_login';
    const REFERRAL_CODE        = 'referral_code';
    const ACCOUNT_NAME         = 'account_name';
    const GOOGLE_USER_ID       = 'google_user_id';
    const LINKEDIN_USER_ID     = 'linkedin_user_id';
    const LAST_LOGIN_IP        = 'last_login_ip';
    const LAST_LOGIN_CLIENT    = 'last_login_client';
    const  VERIFICATION_TOKEN  = 'verification_token';
    const SLUG                 = 'slug';

    //Role const 
    const ADMIN     = 'admin';
    const MANAGER   = 'manager';
    const USER      = 'user';

    //Status const 
    const CONFORM   =         'conform';
    const PENDING   =         'pending';
    const BLOCK     =         'block';

    //Enum option
    const STATUS_ENUM          = [self::CONFORM, self::PENDING, self::BLOCK];
    const ROLE_ENUM             = [self::ADMIN, self::MANAGER, self::USER];

    const FILLABLE = [
        'FIRST_NAME'         => self::FIRST_NAME,
        'LAST_NAME'          => self::LAST_NAME,
        'EMAIL'              => self::EMAIL,
        'PASSWORD'           => self::PASSWORD,
        'ROLE'               => self::ROLE,
        'PROFILE_IMAGE'      => self::PROFILE_IMAGE,
        'STATUS'             => self::STATUS,
        'LANGUAGE'           => self::LANGUAGE,
        'LAST_LOGIN'         => self::LAST_LOGIN,
        'REFERRAL_CODE'      => self::REFERRAL_CODE,
        'ACCOUNT_NAME'       => self::ACCOUNT_NAME,
        'GOOGLE_USER_ID'     => self::GOOGLE_USER_ID,
        'LINKEDIN_USER_ID'   => self::LINKEDIN_USER_ID,
        'LAST_LOGIN_IP'      => self::LAST_LOGIN_IP,
        'LAST_LOGIN_CLIENT'  => self::LAST_LOGIN_CLIENT,
        'VERIFICATION_TOKEN' => self::VERIFICATION_TOKEN,
        'SLUG'               => self::SLUG,
    ];

    protected $fillable = self::FILLABLE;

    protected $hidden = [
        self::PASSWORD,
        self::STATUS,
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });
        static::creating(function ($user) {
            $user->slug = Str::slug($user->first_name . $user->last_name);

            $slug = $user->slug;
            $int = 1;

            while (static::where('slug', $user->slug)->exists()) {
                $user->slug = $slug . '-' . $int++;
            }
        });
        static::updating(function ($user) {
            $user->slug = Str::slug($user->first_name . $user->last_name . $user->id);
        });
    }

    public static function loginUpdate($request)
    {
        $user = $request->user();
        $last_login_ip = substr($request->ip(), 0, 200);
        $last_login_client = substr($request->header('user-agent'), 0, 200);
        User::where('id', $user->id)->update(['last_login' => date('Y-m-d H:i:s'), 'last_login_ip' => $last_login_ip, 'last_login_client' => $last_login_client]);
    }

    public function whiteLabelSettings()
    {
        return $this->hasOne(whiteLabelSettings::class);
    }
    public function report()
    {
        return $this->hasOne(ReportTemplate::class);
    }
    public function customSection()
    {
        return $this->hasMany(ReportTemplateCustomSection::class, 'user_id', 'id');
    }
}
