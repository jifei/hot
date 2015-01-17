<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Validator;
class PasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth      = $auth;
        $this->passwords = $passwords;
        $this->middleware('csrf', ['only' => ['postReset','postEmail']]);
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required']);

        switch ($response = $this->passwords->sendResetLink($request->only('email'), function ($message) {
            //$message->setCharset('utf-8');
            $message->subject("找回密码");
            //quoted_printable_encode
        })) {
            case PasswordBroker::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token'    => 'required',
            'email'    => 'required',
            'password' => 'required|confirmed|min:6|max:20',
        ]);

        //验证提示信息
        $messages = [
            'token.required'    => 'token不存在!',
            'email.required'    => '邮箱不能为空',
            'password.required' => '密码不能为空',
            'password.min'      => '密码长度不能少于6个字符!',
            'password.max'      => '密码长度不能大于20个字符!',];

        //验证规则
        $rules = [
            'token'    => 'required',
            'email'    => 'required',
            'password' => 'required|confirmed',
        ];

        $validator = Validator::make($request, $rules, $messages);


        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset($credentials, function ($user, $password) {
            $user->password = bcrypt($password);

            $user->save();

            $this->auth->login($user);
        });

        switch ($response) {
            case PasswordBroker::PASSWORD_RESET:
                return redirect($this->redirectPath());

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

}
