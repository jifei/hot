<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/28
 * Time: 13:37
 */
namespace App\Repositories;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;

class Repository
{
    /**
     * 成功返回
     *
     * @param array $data
     * @param string $msg
     *
     * @return array
     */
    public static function success($data = array(), $msg = 'ok')
    {
        return [true, $data, $msg];
    }

    /**
     * 失败返回
     *
     * @param       $msg
     * @param array $data
     *
     * @return array
     */
    public static function fail($msg, $data = array())
    {
        return [false, $data, $msg];
    }


    /**
     * 格式化输出验证器9
     *
     * @param Validator $validator
     *
     * @return array
     */
    public static function format_validator(Validator $validator)
    {
        if ($validator->fails()) {
            return self::fail($validator->messages()->first());
        }

        return self::success();
    }

    public static function format_result(Model $data, $format = 'array')
    {
        dd($data);
        if ($format == 'array') {
            return $data ? $data->toArray() : array();
        }
        return $data;
    }

}