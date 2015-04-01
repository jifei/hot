<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Auth;
use Request;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    public function __construct()
    {
        $this->login_user = Auth::user();
    }

    /**
     * 成功json
     *
     * @param array  $data
     * @param string $msg
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function jsonSuccess($data = array(), $msg = 'ok')
    {
        return response()->json(array('data' => self::_toString($data), 'msg' => $msg, 'code' => 200))->send();
    }

    /**
     * 失败返回
     *
     * @param       $msg
     * @param int   $code
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Responsese
     */
    public static function jsonFail($msg, $code = 400, $data = array())
    {
        return response()->json(array('data' => self::_toString($data), 'msg' => $msg, 'code' => intval($code)))->send();
    }

    /**
     * json返回数据
     *
     * @param $code
     * @param $data
     * @param $msg
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function jsonResult($code, $data, $msg)
    {
        return response()->json(array('data' => self::_toString($data), 'msg' => $msg, 'code' => intval($code)))->send();
    }

    public static function getPage()
    {
        $page      = Request::input('page', 1);
        $page      = min(20, max(1, intval($page)));
        $page_size = Request::input('page_size', 1);
        $page_size = min(200, max(1, intval($page_size)));

        return array($page, $page_size);
    }

    /**
     * 转字符串
     *
     * @param $data
     *
     * @return array|string
     */
    public static function _toString($data)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::_toString($v);
            }

            return $data;
        }

        return (string)$data;
    }

}
