<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:53
 */
namespace App\Http\Controllers;

use App\Repositories\Feed\FeedRepository;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->feed = new FeedRepository();
    }

    public function index()
    {
        echo \App::environment();
    }

    public function add()
    {
        $data =$this->feed->create(array('title'=>'12356','link'=>'http://www.baidu.com','uid'=>2,'bid'=>3));
        var_dump($data);exit;
    }
}