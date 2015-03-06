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

//Composer
View::composers(
    array(
        'App\Http\Composer\AdminSidebarComposer' => 'admin.include.sidebar',
        'App\Http\Composer\AdminHeaderComposer'  => 'admin.include.header',
    )
);

$router->pattern('id', '[0-9]+');
$router->pattern('controller', '[a-zA-Z0-9]+');
$router->pattern('action', '[a-zA-Z0-9]+');

//API
Route::group(
    ['domain' => 'api2.shangyt.cn', 'middleware' => 'auth.api'],
    function () {
        Route::get('user/latest', 'Api');
        Route::resource('user', 'Api\UserController');
        Route::resource('test', 'Api\TestController');
    }
);

//admin后台
Route::group(array('domain' => 'admin.hot.com'), function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::any('/login', 'Admin\AuthController@login');
    Route::get('/logout', 'Admin\AuthController@logout');

    Route::any('/{controller}', function ($controller) {
        $c = 'App\Http\Controllers\Admin\\' . ucfirst($controller) . 'Controller';
        return class_exists($c) ? call_user_func_array([new $c(), Config::get('app.default_action')], []) : abort(404);
    });

    Route::any('/{controller}/{action}', function ($controller, $action) {
        $c = 'App\Http\Controllers\Admin\\' . ucfirst($controller) . 'Controller';
        return class_exists($c) ? call_user_func_array([new $c(), $action], []) : abort(404);
    });

    Route::any('/{controller}/{action}/{id}', function ($controller, $action, $id) {
        $c = 'App\Http\Controllers\Admin\\' . ucfirst($controller) . 'Controller';
        return class_exists($c) ? call_user_func_array([new $c(), $action], array($id)) : abort(404);
    });

});
//Route::get('/', 'WelcomeController@index');

Route::get('/', 'FeedController@index');

Route::get('home', 'HomeController@index');
Route::get('home/info', 'HomeController@info');
Route::get('f/get', 'FeedController@get');
Route::get('f/index', 'FeedController@index');

Route::post('f/add', 'FeedController@add');
Route::post('comment/add/{key}', 'CommentController@add');
Route::post('f/up', 'FeedController@up');
Route::post('f/down', 'FeedController@down');
Route::get('api', 'Api\IndexController@index');
Route::get('admin', 'Admin\IndexController@index');
Route::get('/f/{key}', 'FeedController@detail');
Route::get('/f/{key}/comment', 'FeedController@detail');
Route::get('/l/{key}', 'FeedController@link');
Route::get('/b/search', 'BoardController@search');
Route::get('/b/{key}', 'BoardController@feed');

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


