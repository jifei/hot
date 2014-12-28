<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Repositories\User\UserRepository;

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
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->user= \App::make("App\Repositories\User\UserRepository");
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
        //echo $validator->fails();
        //var_dump($validator->messages());
//        if ($validator->fails())
//        {
//            $this->throwValidationException(
//                $request, $validator
//            );
//        }
        $this->auth->login($this->registrar->create($request->all()));    }


}
