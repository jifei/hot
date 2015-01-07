<?php namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{

    use ValidatesRequests;

    /***
     *
     * 过滤输出时的NULL值
     *
     * @param $arr
     * @return array|string
     */
    private function _nullToString($arr)
    {
        if (is_object($arr)) {
            $arr = get_object_vars($arr);
        }
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $i => $v) {
                    $arr[$i] = $this->_nullToString($v);
                }
            }
        } else {
            $arr = strval($arr);
        }

        return $arr;
    }

    /***
     *
     * API返回错误
     *
     * @param       $msg '错误信息'
     * @param array $data '错误数据'
     * @param int $code '错误代码'
     * @param bool $return '是否返回'
     * @return bool|void
     */
    protected function sendError($msg, $data = array(), $code = 400, $return = false)
    {
        header("Content-Type: application/json");
        $data = $this->_nullToString($data);
        $ret  = json_encode(array("code" => $code, "data" => $data, "msg" => $msg));
        if ($return) {
            return $ret;
        }
        echo $ret;
        exit;
    }

    /****
     *
     * API返回成功
     *
     * @param      $data
     * @param      $msg
     * @param bool $return
     * @return string
     */
    protected function sendSuccess($data, $msg = 'ok', $return = false)
    {
        header("Content-Type: application/json");
        $data = $this->_nullToString($data);
        $ret  = json_encode(array("code" => 200, "data" => $data, "msg" => $msg));
        if ($return) {
            return $ret;
        }
        echo $ret;
        exit;
    }
}
