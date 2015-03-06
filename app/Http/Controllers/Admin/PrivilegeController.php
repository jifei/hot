<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/10
 * Time: 上午11:10
 */
namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\PrivilegeRepository;
use App\Libraries\Classes\Tree;
use Request;


class PrivilegeController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->repos = new PrivilegeRepository();
    }

    public function index()
    {
        return view('admin.privilege.index');
    }

    public function all()
    {
        $pid         = Request::input("id");
        $select_keys = array();
        if (!empty($pid)) {
            $model = $this->repos->getModel($pid);
            if (!empty($model['ppid'])) {
                $select_keys[] = $model['ppid'];
            }
        }
        $data = $this->repos->getPrivileges();
        $tree = new Tree('pid', 'ppid');
        $tree->load($data, null, $select_keys);
        return response()->json($tree->buildTree(0));
    }

}