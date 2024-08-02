<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    const TABLE_NAME = 'features';
    const ID   = 'id';
    const NAME   = 'name';
    const SLUG   = 'slug';
    const DESCRIPTION   = 'description';
    const VALUE   = 'value';
    const ORDERING = 'ordering';

    protected $fillable = [
        'NAME' => self::NAME,
        'SLUG' => self::SLUG,
        'DESCRIPTION' => self::DESCRIPTION,
        'VALUE' => self::VALUE,
        'ORDERING' => self::ORDERING,
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plans_features', 'features_id', 'plan_id');
    }
}
