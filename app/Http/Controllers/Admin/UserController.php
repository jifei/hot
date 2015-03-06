<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/10
 * Time: 上午11:10
 */
namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\GroupRepository;
use Request;

class UserController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->repos = $this->user;
    }

    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * 设置
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function setting()
    {
        if (Request::isMethod('post')) {
            if (empty(Request::input('password'))) {
                return view('admin.user.setting')->with('error', '密码不能为空');
            }
            list($code, , $msg) = $this->repos->edit($this->login_admin_uid, Request::all());
            if ($code != 200) {
                return view('admin.user.setting')->with('error', $msg);
            }
            return view('admin.user.setting')->with('success', true);
        }
        return view('admin.user.setting');
    }

    /**
     * 获取用户组
     * @return \Illuminate\View\View
     */
    public function groups()
    {
        $group               = new GroupRepository();
        $uid                 = Request::input('uid');
        $data['error']       = "";
        $data['user_groups'] = array();
        $data['groups']      = array();
        if (!$uid) {
            $data['error'] = "用户不存在";
        } else {
            $data['user_groups'] = $this->repos->getUserGroups($uid)->lists('gid');
            $data['groups']      = $group->getGroups();
        }
        return view('admin.user.groups', $data);


    }

    public function setGroups($id)
    {
        $user = $this->repos->getModel($id);
        if (!$user) {
            return self::jsonFail('用户不存在');
        }
        list($code, , $msg) = $this->repos->setGroups($id, Request::input('group_ids'));
        if ($code != 200) {
            return self::jsonFail($msg, $code);
        }
        return self::jsonSuccess();

    }
}