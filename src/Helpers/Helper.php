<?php

namespace Rodineiti\SmartfastpaySdk\Helpers;

class Helper
{
    public static function dd(...$vars)
    {
        print "<pre>" . print_r($vars, true) . "</pre>";
        die();
    }

    public static function dump(...$vars)
    {
        print "<pre>" . print_r($vars, true) . "</pre>";
    }
}