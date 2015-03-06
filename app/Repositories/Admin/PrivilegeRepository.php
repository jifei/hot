<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/4
 * Time: 下午2:28
 */
namespace App\Repositories\Admin;

use App\Models\AdminPrivilege;
use App\Repositories\Repository;
use Validator;

class PrivilegeRepository extends Repository
{
    static $model_name           = 'AdminPrivilege';
    static $add_validator_rules  = ['title' => 'required|min:2|max:20',];
    static $edit_validator_rules = ['title' => 'required|min:2|max:20',];
    static $validator_messages   = ['title.required' => '权限名称不能为空!',
                                    'title.min'      => '权限名称偏短',
                                    'title.max'      => '权限名称偏长',
                                    'title.unique'   => '权限名称已存在',
    ];


    public function getPrivileges()
    {
        return self::formatResult(AdminPrivilege::where('status', 1)->orderBy('ppid', 'asc')->orderBy('pid', 'asc')->get());
    }

    /**
     * 获取之前操作
     * @param $filter
     * @param $model
     * @return mixed
     */
    public function beforeGet($filter, $model)
    {
        return $model->with('parent');
    }

    /**
     * 编辑前操作
     * @param $id
     * @param $data
     * @return array
     */
    public function beforeEdit($id, $data)
    {
        list($code, $data, $msg) = parent::beforeEdit($id, $data);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        if ($id == $data['ppid']) {
            return self::fail("父级不能为自己");
        }
        $model = $this->getModel($data['ppid']);
        if ($model && $model['ppid'] == $id) {
            return self::fail("父级不能为当前子孙");
        }
        return self::success($data);

    }

    /**
     *
     * @param $url
     * @return array|null
     */
    public function getPrivilegeByUrl($url)
    {
        if (!$url) {
            return null;
        }
        return self::formatResult(AdminPrivilege::where('url', $url)->first());
    }


}