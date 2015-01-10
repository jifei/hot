<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Response;

abstract class Controller extends BaseController
{

    use ValidatesRequests;

    /**
     *
     * ajax fail
     * @param       $msg
     * @param int   $code
     * @param array $data
     *
     * @return mixed
     */
    public static function ajaxFail($msg, $code = 400, $data = array())
    {
        return Response::json(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }

    /**
     * ajax success
     * @param        $data
     * @param int    $code
     * @param string $msg
     *
     * @return mixed
     */
    public static function ajaxSuccess($data=array(), $code = 200, $msg = 'ok')
    {
        return Response::json(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }

}
