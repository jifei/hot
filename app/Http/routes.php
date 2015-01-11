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
Route::get('home/info', 'HomeController@info');
Route::get('f/get', 'FeedController@get');
Route::get('f/index', 'FeedController@index');

Route::post('f/add', 'FeedController@add');
Route::get('api', 'Api\IndexController@index');
Route::get('admin', 'Admin\IndexController@index');
Route::get('/f/{key}', 'FeedController@detail');
Route::get('/b/search', 'BoardController@search');
Route::get('/b/{key}', 'FeedController@list');

$ApiRoute = function () {
};
Route::group(['domain' => 'api.redudian.com'], $ApiRoute);
Route::group(['domain' => 'test.redudian.com'], $ApiRoute);



//Composer
View::composer('includes.navbar','App\Http\Composer\NavbarComposer');
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
