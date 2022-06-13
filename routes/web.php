<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Services\CheckCharsService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/file', function () {
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

        if ($value == '\\') {
            $value = "";
        }
        array_push($result, $value);
    }

    $result = implode("", $result);
    $result = json_decode($result, true);
    
    echo "<pre>"; var_dump($result); echo "<pre>";
});