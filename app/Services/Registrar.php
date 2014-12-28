<?php namespace App\Services;

use App\Repositories\User\UserRepository;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract
{

    public function __construct(){
        $this->user = new UserRepository();
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {


        //验证提示信息
        $messages = [
            'name.required'   => '用户名不能为空!',
            'name.min'        => '长度不能少于4个字符!',
            'name.max'        => '长度不能大于20个字符!',
            'name.alpha_dash' => '只允许数字、字母、下划线、中划线!',
            'name.unique'     => '用户名已经存在!',
            'nickname.required'    => '昵称不能为空!',
            'nickname.min'         => '长度不能少于2个字符!',
            'nickname.max'         => '长度不能大于20个字符!',
            'nickname.unique'      => '昵称已经存在!',
            'password.required'    => '密码不能为空!',
            'password.min'         => '长度不能少于6个字符!',
            'password.max'         => '长度不能大于20个字符!',
            'email.required'       => '邮箱不能为空!',
            'email.email'          => '邮箱地址不正确!!',
            'email.unique'         => '邮箱已经存在!',
            'email.max'            => '长度不能大于40个字符!',
        ];

        //验证规则
        $rules = [
            'name' => 'required|min:4|max:20|alpha_dash|unique:user',
            'nickname'  => 'required|min:2|max:20|unique:user',
            'password'  => 'required|min:6|max:20',
            'email'     => 'required|email|unique:user|max:40'
        ];

        return Validator::make($data, $rules,$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        return $this->user->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}
