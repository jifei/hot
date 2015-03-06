<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/4
 * Time: 下午2:28
 */
namespace App\Repositories\Admin;

use App\Models\AdminUser;
use App\Models\AdminUserGroup;
use App\Repositories\Repository;
use Validator;

class UserRepository extends Repository
{
    const  PASSWORD_ALGO = PASSWORD_BCRYPT;//加密算法
    const  REMEMBER_DAYS = 7;//记忆天数
    static $model_name           = 'AdminUser';
    static $add_validator_rules  = ['name'      => 'required|min:2|max:20|unique:admin_user',
                                    'password'  => 'required|min:6|max:20|confirmed',
                                    'real_name' => 'required|min:2|max:20',
                                    'email'     => 'required|email',];
    static $edit_validator_rules = ['password'  => 'min:6|max:20|confirmed',
                                    'real_name' => 'min:2|max:20',
                                    'email'     => 'email',];
    static $validator_messages   = ['name.required'      => '账号不能为空!',
                                    'name.min'           => '账号偏短',
                                    'name.max'           => '账号偏长',
                                    'name.unique'        => '账号已存在',
                                    'real_name.required' => '真实姓名不能为空!',
                                    'real_name.min'      => '真实姓名偏短',
                                    'real_name.max'      => '真实姓名偏长',
                                    'email.required'     => '邮箱不能为空',
                                    'email.email'        => '邮箱地址填写不正确',
                                    'password.required'  => '密码不能为空!',
                                    'password.min'       => '密码长度偏短',
                                    'password.max'       => '密码长度偏长',
                                    'password.confirmed' => '密码不一致',];


    /**
     * 登录
     * @param $name
     * @param $password
     * @param bool $remember_me
     * @return array
     */
    public function login($name, $password, $remember_me = false)
    {
        $user = $this->getUserByName($name, self::FORMAT_OBJECT);
        if (!$user) {
            return self::fail('账号已被锁定');
        }
        if (!password_verify($password, $user['password'])) {
            return self::fail('账号或密码错误');
        }
        if (true === password_needs_rehash($password, self::PASSWORD_ALGO)) {
            //rehash password
            $user->password = password_hash($password, self::PASSWORD_ALGO);
        }
        //remember me
        if ($remember_me) {
            $user->remember_token    = password_hash(md5($user->uid . time()), self::PASSWORD_ALGO);
            $user->token_expire_time = date('Y-m-d H:i:s', strtotime("+ " . self::REMEMBER_DAYS . " days"));
        }
        $user->last_login_time = date('Y-m-d H:i:s');
        $user->last_login_ip   = getIp();
        $user->save();
        return self::success($user->toArray(), '登陆成功');
    }

    /**
     * 退出
     * @param $uid
     */
    public function logout($uid)
    {
        $user = AdminUser::find($uid);
        if ($user) {
            $user->token_expire_time = date('Y-m-d H:i:s');
            $user->remember_token    = null;
        }
        $user->save();
    }

    /**
     * 获取之前操作
     * @param $filter
     * @param $model
     * @return mixed
     */
    public function beforeGet($filter, $model)
    {
        return $model->with('groups');
    }

    /**
     * 添加前操作
     * @param $data
     * @return array
     */
    public function beforeAdd($data)
    {
        list($code, $data, $msg) = parent::beforeAdd($data);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        if (!empty($data['mobile']) && !checkMobile($data['mobile'])) {
            return self::fail('手机号填写不正确');
        }
        $data['password'] = password_hash($data['password'], self::PASSWORD_ALGO);
        return self::success($data);
    }

    /**
     * 编辑前操作
     * @param $data
     * @return array
     */
    public function beforeEdit($id, $data)
    {
        unset($data['name']);
        list($code, $data, $msg) = parent::beforeEdit($id, $data);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        if (!empty($data['mobile']) && !checkMobile($data['mobile'])) {
            return self::fail('手机号填写不正确');
        }
        if (isset($data['password']) && strlen($data['password'])) {
            $data['password'] = password_hash($data['password'], self::PASSWORD_ALGO);
        } else {
            unset($data['password']);
        }
        return self::success($data);
    }


    /**
     * 根据用户名获取用户信息
     * @param $name
     * @param string $format
     * @return array
     */
    public function getUserByName($name, $format = self::FORMAT_ARRAY)
    {
        return self::formatResult(AdminUser::where('name', $name)->where('status', 1)->first(), $format);
    }

    /**
     * 根据token获取用户
     * @param $remember_token
     * @param string $format
     * @return array
     */
    public function getUserByToken($remember_token, $format = self::FORMAT_ARRAY)
    {
        return self::formatResult(AdminUser::where('remember_token', $remember_token)->where('token_expire_time', '>', date('Y-m-d H:i:s'))->where('status', 1)->first(), $format);
    }

    /**
     * 获取用户组
     * @param $uid
     * @return array
     */
    public function getUserGroups($uid)
    {
        return self::formatResult(AdminUserGroup::where('uid', $uid)->get(), self::FORMAT_OBJECT);
    }


    public function setGroups($uid, $group_ids)
    {
        AdminUserGroup::where('uid', $uid)->delete();
        $group_ids = explode(',', $group_ids);
        foreach ($group_ids as $v) {
            if (!is_numeric($v)) {
                continue;
            }
            AdminUserGroup::create(array('uid' => $uid, 'gid' => $v));
        }
        return self::success();
    }


}