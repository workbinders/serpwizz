<?php

namespace App\Traits;

trait Helpers
{
    public function dateFormat($date)
    {
        return date(config('serpwizz.date_format', strtotime($date)));
    }
}
