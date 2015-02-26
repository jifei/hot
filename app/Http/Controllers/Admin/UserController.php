<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/10
 * Time: 上午11:10
 */
namespace App\Http\Controllers\Admin;
use Request;

class UserController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->repos = $this->user;
    }

    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * 设置
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function setting()
    {
        if (Request::isMethod('post')) {
            if(empty(Request::input('password'))){
                return view('admin.user.setting')->with('error','密码不能为空');
            }
            list($ok, , $msg) = $this->repos->edit($this->login_admin_uid,Request::all());
            if (!$ok) {
                return view('admin.user.setting')->with('error',$msg);
            }
            return view('admin.user.setting')->with('success',true);
        }
        return view('admin.user.setting');
    }
//    public function add()
//    {
//        if (Request::isMethod('post')) {
//            list($ok, , $msg) = $this->user->add(Request::all());
//            if (!$ok) {
//                return self::ajaxFail($msg);
//            }
//            return self::ajaxSuccess('创建成功');
//        }
//    }
//
//
//    public function data()
//    {
//        $result = $this->user->getDataList();
//        return response()->json($result);
//    }

//    public function del()
//    {
//
//    }
}