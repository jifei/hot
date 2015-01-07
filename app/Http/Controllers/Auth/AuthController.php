<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth      = $auth;
        $this->registrar = $registrar;
        $this->user      = \App::make("App\Repositories\User\UserRepository");
        $this->middleware('guest', ['except' => 'getLogout']);
    }
//
//    public function getRegister(Request $request){
//        $validator = $this->registrar->validator($request->all());
//         echo $validator->fails();
//        var_dump($validator->messages());
////        if ($validator->fails())
////        {
////            $this->throwValidationException(
////                $request, $validator
////            );
////        }
//        $this->auth->login($this->registrar->create($request->all()));
//
//        var_dump($this->user->all());exit;
//    }
    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails()) {
            return $this->ajaxFail($validator->messages()->first());
        }else{
            echo 111;exit;
            $this->auth->login($this->registrar->create($request->all()));
        }
//        if ($validator->fails())
//        {
//            $this->throwValidationException(
//                $request, $validator
//            );
//
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');


        //登录成功
        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            if ($request->ajax()) {
                return $this->ajaxFail('邮箱或者密码错误', '402');
            } else {
                $redirect_url = Input::get('redirect_url');
                if ($redirect_url) {
                    $this->redirectTo = urldecode($redirect_url);
                }

                return redirect()->intended($this->redirectPath());
            }
        }

        //登录失败
        if ($request->ajax()) {
            return $this->ajaxFail('邮箱或者密码错误', '402');
        } else {
            return redirect('/auth/login')
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ]);
        }
    }
}
