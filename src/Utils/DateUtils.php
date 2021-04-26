<?php

namespace App\Utils;

use DateTime;

class DateUtils
{
    public static function formatDateTime($value)
    {
        if (!$value) return null;
        return date_format(new DateTime($value), 'Y-m-d H:i:s');
    }
}