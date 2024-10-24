<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public static function storeData($lead_id, $key, $data)
    {
        self::updateOrCreate(
            ['lead_id' => $lead_id, 'key' => $key],
            ['data' => $data]
        );
    }
}
