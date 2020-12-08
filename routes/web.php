<?php
declare(strict_types=1);

use ArtisanCloud\UBT\Facades\UBT;
use Illuminate\Support\Facades\Route;

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

Route::get('/view/artisan/invitation', function () {
    return view('artisan-cloud::artisan.invitation');
});

Route::get('/view/artisan/registered', function () {
    return view('artisan-cloud::artisan.registered');
});

Route::get('/ubt/info', function () {

    UBT::info('213', ['123' => '321']);

});