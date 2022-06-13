<?php

use Illuminate\Support\Facades\Route;
use App\Services\MigrationDataService;

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
    $data = MigrationDataService::getData();
    echo "<pre>"; var_dump($data); echo "<pre>";
});