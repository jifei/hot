<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\UserRepository;
use App\Http\Controllers\Controller as BaseController;
use App\Repositories\Repository;
use App\Repositories\Admin\PrivilegeRepository;
use App\Libraries\Classes\Tree;
use Session;
use Request;
use Cookie;

abstract class AdminController extends BaseController
{

    //use DispatchesCommands, ValidatesRequests;

    public $login_admin_user = null;
    public $login_admin_uid  = null;
    public $user;//userRepository
    public $repos;//controller bind repository
    public $all_privilege    = array();

    public function __construct()
    {

        $this->repos = new Repository();
        $this->user  = new UserRepository();
        //rebuild data by uid
        $this->login_admin_uid = Session::get('login_admin_uid');
        if ($this->login_admin_uid) {
            $this->login_admin_user = $this->user->getModel($this->login_admin_uid);
        }

        //rebuild data by remember_token
        $admin_remember_token = Cookie::get('admin_remember_token');
        if (!$this->login_admin_user && $admin_remember_token) {
            $this->login_admin_user = $this->user->getUserByToken($admin_remember_token, UserRepository::FORMAT_OBJECT);
            if ($this->login_admin_user) {
                $this->login_admin_uid = $this->login_admin_user->uid;
                Session::put('login_admin_uid', $this->login_admin_uid);
            }
        }
        $path = Request::path();
        //已经登录
        if ($path == 'login' && $this->login_admin_user) {
            if (Request::ajax()) {
                return self::ajaxFail('已经登录，请勿重复登录');
            }
            return redirect()->to('/')->send();
        }
        if (!$this->login_admin_user && $path != 'login') {
            if (Request::ajax()) {
                return self::ajaxFail('未登录，请先登录', 401);
            } else {
                return redirect('/login?redirect_url=' . urlencode(getFullURL()))->send();
            }
        }
        $privilege           = new PrivilegeRepository();
        $this->all_privilege = $privilege->getPrivileges();
//        $tree = new Tree('pid','ppid');
//        $tree->load($this->all_privilege);
        view()->share('allowed_privilege',$this->all_privilege);
        view()->share('login_admin_user', $this->login_admin_user);
    }


    /**
     * 数据列表
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function data()
    {
        $result = $this->repos->getDataList();
        return response()->json($result);
    }

    /**
     * 添加数据
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add()
    {
        list($ok, , $msg) = $this->repos->add(Request::all());
        if (!$ok) {
            return self::ajaxFail($msg);
        }
        return self::ajaxSuccess('创建成功');
    }

    /**
     * 删除操作
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function del($id = null)
    {
        if ($id == null) {
            $id = Request::input('id');
        }
        $ids = explode(',', $id);
        if (count($ids) == 1) {
            list($ok, , $msg) = $this->repos->delete($id);
            if (!$ok) {
                return self::ajaxFail($msg);
            }
        } else {
            $error_ids = array();
            foreach ($ids as $id) {
                list($ok, ,) = $this->repos->delete($id);
                if (!$ok) {
                    $error_ids[] = $id;
                }
            }
            if (!empty($error_ids)) {
                return self::ajaxFail(implode(',', $error_ids) . '删除失败');
            }
        }
        return self::ajaxSuccess('删除成功');
    }

    /**
     * 修改
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit($id = null)
    {
        if ($id == null) {
            $id = Request::input('id');
        }
        list($ok, , $msg) = $this->repos->edit($id, Request::all());
        if (!$ok) {
            return self::ajaxFail($msg);
        }
        return self::ajaxSuccess('修改成功');
    }

}
