<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PlansFeatures extends Model
{
    const NAME = 'name';
    const FEATURES_ID = 'features_id';
    const PLAN_ID = 'plan_id';
    const COUNT   = 'count';

    protected $fillable = [
        'NAME' => self::NAME,
        'FEATURES_ID' => self::FEATURES_ID,
        'PLAN_ID' => self::PLAN_ID,
        'COUNT' => self::COUNT,
    ];
    protected $table = 'plans_features';
}
