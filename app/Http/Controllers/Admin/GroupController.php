<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/10
 * Time: 上午11:10
 */
namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\GroupRepository;
use App\Repositories\Admin\PrivilegeRepository;
use Request;
use App\Libraries\Classes\Tree;

class GroupController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->repos = new GroupRepository();
    }

    public function index()
    {
        return view('admin.group.index');
    }

    /**
     * 查看权限
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function privileges($id)
    {
        //$pid         = Request::input("id");
        $select_keys = $this->repos->getPrivilegesIds($id);
        $privilege   = new PrivilegeRepository();
        $data        = $privilege->getPrivileges();
        $tree        = new Tree('pid', 'ppid');
        $tree->load($data, null, $select_keys);
        return response()->json($tree->buildTree(0));
    }


    public function setPrivileges($id)
    {
        $user = $this->repos->getModel($id);
        if (!$user) {
            return self::jsonFail('用户组不存在');
        }
        list($code, , $msg) = $this->repos->setPrivileges($id, Request::input('pids'));
        if ($code != 200) {
            return self::jsonFail($msg, $code);
        }
        return self::jsonSuccess();
    }
}