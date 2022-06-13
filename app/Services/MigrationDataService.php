<?php

namespace App\Services;

use App\Services\CheckCharsService;
use Illuminate\Support\Facades\Storage;
/**
 * Class MigrationDataService.
 */
class MigrationDataService
{
    public static function getData()
    {
        $status = true; //начальная ковычка
        $result = [];
    
        $content = Storage::disk('public')->get('/mark_models.txt');
        $content = str_replace( '"',"'", $content);
        $array = preg_split('//', $content, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($array as $key => $value) {

            if ($value == "'" && $status) {
                $value = '"';
                $status = false; // прошли начальную точку
            }
            
            if ($value == "'" && !$status && CheckCharsService::check($array[$key],$array[$key+1], $array[$key+2]) && $array[$key+1] != '"') {
                $value = '"';
                $status = true; // прошли конечную точку
            }
            
            $value = stripslashes($value);

            array_push($result, $value);
        }
        
        $result = implode("", $result);
        $result = json_decode($result, true);

        return $result;
    }
}
