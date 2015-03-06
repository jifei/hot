<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
use Response;
use Auth;

abstract class Controller extends BaseController
{

    use ValidatesRequests;


    public function __construct()
    {
        $this->login_user = Auth::user();
    }

    /**
     *
     * ajax fail
     *
     * @param       $msg
     * @param int   $code
     * @param array $data
     *
     * @return mixed
     */
    public static function jsonFail($msg, $code = 400, $data = array())
    {
        return response()->json(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }

    /**
     * ajax success
     *
     * @param        $data
     * @param int    $code
     * @param string $msg
     *
     * @return mixed
     */
    public static function jsonSuccess($data = array(), $code = 200, $msg = 'ok')
    {
        return response()->json(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }

    public static function getPage()
    {
        $page      = Input::get('page', 1);
        $page      = min(20, max(1, intval($page)));
        $page_size = Input::get('page_size', 1);
        $page_size = min(200, max(1, intval($page_size)));

        return array($page, $page_size);
    }
}
