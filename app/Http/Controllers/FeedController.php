<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:53
 */
namespace App\Http\Controllers;

class FeedController extends Controller
{
    public function index()
    {
        echo \App::environment();
    }
}