<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    const TABLE_NAME = 'plans';
    const ID  = 'id';
    const NAME  = "name";
    const SLUG  = "slug";
    const ANNAL_PRICE  = "annual_price";
    const MONTHLY_PRICE = 'monthly_price';
    const DESCRIPTION = 'description';
    const HIGHLIGHT = 'highlight';
    const ORDERING  = 'ordering';

    protected $fillable = [
        'NAME' => self::NAME,
        'SLUG' => self::SLUG,
        'ANNAL_PRICE'   => self::ANNAL_PRICE,
        'MONTHLY_PRICE' => self::MONTHLY_PRICE,
        'DESCRIPTION' => self::DESCRIPTION,
        'HIGHLIGHT'  => self::HIGHLIGHT,
        'ORDERING' => self::ORDERING,
    ];

    protected  $table = 'plans';

    public function planFeatures()
    {
        return $this->belongsToMany(PlansFeatures::class, 'plans_features', 'plan_id', 'features_id');
    }

    public function features()
    {
        return $this->belongsToMany(features::class, 'Plans_Features')->orderBy('ordering','asc');
    }
}
