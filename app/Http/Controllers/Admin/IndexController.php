<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/24
 * Time: 19:58
 */
namespace App\Http\Controllers\Admin;

class IndexController extends Controller
{
    public function index()
    {
        echo \App::environment();
        echo "admin";
    }
}