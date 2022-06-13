<?php

namespace App\Services;

/**
 * Class CheckCharsService.
 */
class CheckCharsService
{
    public static function check($char,$char1, $char2)
    {
        if ($char1 == ']' || $char1 == ":" || $char1 == ",") {
            return true;
        }elseif ($char1 == ' ' &&  $char2 == ':') {
            return true;
        }

        return false;
    }
}
