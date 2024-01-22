<?php

namespace Rodineiti\SmartfastpaySdk\Helpers;

class Helper
{
    public static function dd(mixed ...$vars)
    {
        print "<pre>" . print_r($vars, true) . "</pre>";
        die();
    }

    public static function dump(mixed ...$vars)
    {
        print "<pre>" . print_r($vars, true) . "</pre>";
    }
}