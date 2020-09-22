<?php
declare(strict_types=1);


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$_methodAll = config('artisancloud.framework.router.methodAll', ['options', 'get', 'post', 'put', 'delete']);
$_methodGet = config('artisancloud.framework.router.methodGet', ['options', 'get']);
$_methodPost = config('artisancloud.framework.router.methodPost', ['options', 'post']);
$_methodPut = config('artisancloud.framework.router.methodPut', ['options', 'put']);
$_methodDelete = config('artisancloud.framework.router.methodDelete', ['options', 'delete']);
$_api_version = config('artisancloud.framework.api_version');
$_namespaceAPI = 'ArtisanCloud\SaaSPolymer\Http\Controllers\API';

$_domain_land = config('artisancloud.framework.domain.land');

/** Tenant **/
Route::group(
    [
        'namespace' => $_namespaceAPI,
        'prefix' => "api/{$_api_version}",
        'domain' => $_domain_land,
        'middleware' => ['checkHeader']
    ], function () use ($_methodGet, $_methodPost, $_methodPut, $_methodDelete) {

    Route::match($_methodGet, 'landlord/list', 'LandlordAPIController@apiGetList')->name('landlord.read.list');

    Route::match($_methodPost, 'invitation/generate', 'InvitationCodeAPIController@apiGenerateCode')->name('code.write.invitation.generate');

    Route::match($_methodPost, 'artisan/register/invitation', 'ArtisanAPIController@apiRegisterInvitation')->name('artisan.write.register.invitation');


});


Route::group(
    [
        'namespace' => $_namespaceAPI,
        'prefix' => "api/{$_api_version}",
        'domain' => $_domain_land,
        'middleware' => ['checkHeader', 'auth:api', 'checkUser']
    ], function () use ($_methodGet, $_methodPost, $_methodPut, $_methodDelete) {

//    Route::match($_methodPost, 'invitation/generate', 'InvitationCodeAPIController@apiBatchGenerateCode')->name('code.write.invitation.generate');
});