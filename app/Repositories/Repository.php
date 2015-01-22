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
    const FORMAT_OBJECT = 'object';
    const FORMAT_ARRAY = 'array';

    /**
     * 成功返回
     *
     * @param array  $data
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

    /**
     * 输出指定格式
     *
     * @param        $data
     * @param string $format
     *
     * @return array
     */
    public static function format_result($data, $format = self::FORMAT_ARRAY)
    {
        if ($format == 'array') {
            return method_exists($data, 'toArray') ? $data->toArray() : array();
        }

        return $data;
    }

}