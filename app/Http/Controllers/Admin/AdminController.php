<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\UserRepository;
use App\Http\Controllers\Controller as BaseController;
use App\Repositories\Repository;
use App\Repositories\Admin\PrivilegeRepository;
use App\Libraries\Classes\Tree;
use Session;
use Request;
use Cookie;
use URL;

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
                return self::jsonFail('已经登录，请勿重复登录');
            }
            return redirect()->to('/')->send();
        }
        if (!$this->login_admin_user && $path != 'login') {
            if (Request::ajax()) {
                return self::jsonFail('未登录，请先登录', 401);
            } else {
                return redirect('/login?redirect_url=' . urlencode(getFullURL()))->send();
            }
        }
        $privilege           = new PrivilegeRepository();
        $this->all_privilege = $privilege->getPrivileges();
        //menu_tree
        $tree = new \App\Libraries\Classes\Tree('pid', 'ppid');
        $tree->load($this->all_privilege, $this->all_privilege);
        $current_privilege = $privilege->getPrivilegeByUrl('/' . $path);
        if (isset($current_privilege['pid'])) {
            $tree->current_id   = $current_privilege['pid'];
            $tree->current_name = $current_privilege['title'];
            $tree->findParent($current_privilege['pid']);
        }
        //$tree->printAllowedTree($tree->buildTree(), 1);
        view()->share('menu_tree', $tree);
        //view()->share('allowed_privilege',$this->all_privilege);
        view()->share('login_admin_user', $this->login_admin_user);
    }


    /**
     * 数据列表
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function data()
    {
        $filters = (array)json_decode(Request::input('filters'));
        $filter  = array();
        if (!empty($filters['rules'])) {
            foreach ($filters['rules'] as $v) {
                $v=(array)$v;
                $filter[$v['field']] = $v['data'];
            }
        }
        $result = $this->repos->getDataList($filter);
        return response()->json($result);
    }

    /**
     * 添加数据
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add()
    {
        list($code, , $msg) = $this->repos->add(Request::all());
        if ($code != 200) {
            return self::jsonFail($msg, $code);
        }
        return self::jsonSuccess('创建成功');
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
            list($code, , $msg) = $this->repos->delete($id);
            if ($code != 200) {
                return self::jsonFail($msg, $code);
            }
        } else {
            $error_ids = array();
            foreach ($ids as $id) {
                list($code, ,) = $this->repos->delete($id);
                if ($code != 200) {
                    $error_ids[] = $id;
                }
            }
            if (!empty($error_ids)) {
                return self::jsonFail(implode(',', $error_ids) . '删除失败', $code);
            }
        }
        return self::jsonSuccess('删除成功');
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
        list($code, , $msg) = $this->repos->edit($id, Request::all());
        if ($code != 200) {
            return self::jsonFail($msg, $code);
        }
        return self::jsonSuccess('修改成功');
    }

}
