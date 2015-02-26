<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/27
 * Time: 01:03
 */
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Repository;
use Validator;


class UserRepository extends Repository
{
    public function __construct()
    {
    }

    public function all()
    {
        return User::all();
        //$this->user::findAll(1);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function emailValidator(array $data)
    {
        //验证提示信息
        $messages = [
            'email.required' => '邮箱不能为空!',
            'email.email'    => '邮箱地址不正确!!',
            'email.unique'   => '邮箱已经存在!',
            'email.max'      => '长度不能大于40个字符!',
        ];

        //验证规则
        $rules = [
            'email' => 'required|email|unique:user|max:40'
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function create($data)
    {
        return User::create($data);
    }


}
