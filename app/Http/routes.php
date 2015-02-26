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
//admin后台
Route::group(array('domain' => 'admin.hot.com'), function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::any('/login', 'Admin\AuthController@login');
    Route::get('/logout', 'Admin\AuthController@logout');
    Route::any('/user', 'Admin\UserController@index');
    // Route::any('/user/{action}', 'Admin\UserController@{$action}');

    Route::any('/user/add', 'Admin\UserController@add');
    Route::any('/user/data', 'Admin\UserController@data');
    Route::any('/user/del', 'Admin\UserController@del');
    Route::any('/user/edit', 'Admin\UserController@edit');
    Route::any('/user/setting', 'Admin\UserController@setting');
    Route::any('/group', 'Admin\GroupController@index');
    Route::any('/group/add', 'Admin\GroupController@add');
    Route::any('/group/data', 'Admin\GroupController@data');
    Route::any('/group/del', 'Admin\GroupController@del');
    Route::any('/group/edit', 'Admin\GroupController@edit');
    Route::any('/privilege', 'Admin\PrivilegeController@index');
    Route::any('/privilege/add', 'Admin\PrivilegeController@add');
    Route::any('/privilege/data', 'Admin\PrivilegeController@data');
    Route::any('/privilege/del', 'Admin\PrivilegeController@del');
    Route::any('/privilege/edit', 'Admin\PrivilegeController@edit');
    Route::any('/privilege/setting', 'Admin\PrivilegeController@setting');
    Route::any('/privilege/all', 'Admin\PrivilegeController@all');

});
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

$ApiRoute = function () {
};
Route::group(['domain' => 'api.redudian.com'], $ApiRoute);
Route::group(['domain' => 'test.api.redudian.com'], $ApiRoute);



//Composer
View::composer('includes.navbar','App\Http\Composer\NavbarComposer');

//Composer
View::composers(
    array(
        'App\Http\Composer\AdminSidebarComposer' => 'admin.include.sidebar',
        'App\Http\Composer\AdminHeaderComposer'  => 'admin.include.header',
    )
);


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
