<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('feed', 'FeedController@index');
Route::get('feed/add', 'FeedController@add');
Route::get('api', 'Api\IndexController@index');
Route::get('admin', 'Admin\IndexController@index');

$ApiRoute = function () {
};
Route::group(['domain' => 'api.redudian.com'], $ApiRoute);
Route::group(['domain' => 'test.redudian.com'], $ApiRoute);

//$router->get('feed', function()
//{
//    return 'Hello World';
//});
/*
|--------------------------------------------------------------------------
| Authentication & Password Reset Controllers
|--------------------------------------------------------------------------
|
| These two controllers handle the authentication of the users of your
| application, as well as the functions necessary for resetting the
| passwords for your users. You may modify or remove these files.
|
*/
//App::bind('UserRepository');


Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
