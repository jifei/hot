<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\UserRepository;
use Request;
use Session;
use Cookie;

class AuthController extends AdminController
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */


//    public function __construct()
//    {
//        parent::__construct();
//    }

    /**
     * 登录
     * @return $this|\Illuminate\View\View
     */
    public function login()
    {
        if (Request::isMethod('post')) {
            list($code, $data, $msg) = $this->user->login(Request::get('name'), Request::get('password'), Request::get('remember_me'));
            if ($code == 200) {
                Session::put('login_admin_uid', $data['uid']);
                if (!empty(Request::get('remember_me'))) {
                    Cookie::queue('admin_remember_token', $data['remember_token'], UserRepository::REMEMBER_DAYS * 24 * 60);
                }
                return redirect()->to(urldecode(Request::input('redirect_url', '/')));
            } else {
                return view('admin.login')->with('error', $msg);
            }
        }
        return view('admin.login');
    }

    /**
     * 退出
     * @return \Illuminate\View\View
     */
    public function logout()
    {
        $this->user->logout($this->login_admin_uid);
        Session::flush();
        $cookie = Cookie::forget('admin_remember_token');
        return redirect('/login')->withCookie($cookie);
    }

}
