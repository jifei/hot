<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/4
 * Time: 下午2:28
 */
namespace App\Repositories\Admin;

use App\Models\AdminGroup;
use App\Models\AdminGroupPrivilege;
use App\Repositories\Repository;
use Validator;

class GroupRepository extends Repository
{
    static $model_name           = 'AdminGroup';
    static $add_validator_rules  = ['group_name' => 'required|min:2|max:20|unique:admin_group',];
    static $edit_validator_rules = ['group_name' => 'required|min:2|max:20',];
    static $validator_messages   = ['group_name.required' => '用户组不能为空!',
                                    'group_name.min'      => '用户组偏短',
                                    'group_name.max'      => '用户组偏长',
                                    'group_name.unique'   => '用户组已存在',
    ];

    public function getGroups()
    {
        return self::formatResult(AdminGroup::where('status', 1)->get());
    }

    /**
     * 获取权限ID
     * @param $gid
     * @return mixed
     */
    public function getPrivilegesIds($gid)
    {
        return AdminGroup::with('privileges')->find($gid)->privileges->lists('pid');
    }

    public function setPrivileges($gid, $pids)
    {
        AdminGroupPrivilege::where('gid', $gid)->delete();
        $pids = explode(',', $pids);
        foreach ($pids as $v) {
            if (!is_numeric($v)) {
                continue;
            }
            AdminGroupPrivilege::create(array('gid' => $gid, 'pid' => $v));
        }
        return self::success();
    }
}