<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    $content = Storage::disk('public')->get('/mark_models.txt');
    
    //Формат json приводим к корректному виду так как данные в файле не соответствуют формату 
    $content = substr($content,1,-1);
    $content = str_replace("{'", '{"', $content);
    $content = str_replace("':", '":', $content); 
    $content = str_replace('\"', '', $content);
    $content = str_replace('\\', '', $content);
    $content = str_replace(", '", ', "', $content);
    $content = str_replace("',", '",', $content);
    $content = str_replace("['", '["', $content);
    $content = str_replace("']", '"]', $content);
    $content = str_replace(' {', ' ', $content);
    $content = str_replace('},', ',', $content);    

    return json_decode($content);

});
