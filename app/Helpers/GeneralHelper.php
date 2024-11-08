<?php

namespace App\Helpers;

class GeneralHelper
{
    public static function currency($total)
    {
        return 'Rp.' . number_format($total, 0, '', '.');
    }
}
