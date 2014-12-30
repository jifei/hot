<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/29
 * Time: 20:49
 */

namespace App\Repositories\Board;

use App\Repositories\Repository;
use App\Models\Board;

class BoardRepository extends Repository
{
    public function validator(array $data)
    {
        //验证提示信息
        $messages = [
            'code.required' => '版块code不能为空',
            'name.required' => '版块名称不能为空',
            'code.min'      => '版块code偏短',
            'code.max'      => '版块code偏长',
            'name.min'      => '版块名称偏短',
            'name.max'      => '版块名称偏长',
            'name.unique'   => '版块名称已存在',
            'code.unique'   => '版块code已存在',
        ];

        //验证规则
        $rules = [
            'code' => 'required|min:9|max:100|unique:board',
            'name' => 'required|min:4|max:100|unique:board',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 创建
     * @param $data
     *
     * @return array
     */
    public function create($data)
    {
        list($ok, , $msg) = self::format_validator($this->validator($data));
        if (!$ok) {
            return self::fail($msg);
        }

        $ret = Board::create($data);
        return self::success($ret->toArray());
    }
} 