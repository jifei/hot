<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:53
 */
namespace App\Http\Controllers;

use App\Repositories\Feed\FeedRepository;
use Illuminate\Support\Facades\Request;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->feed = new FeedRepository();
        echo 'construct';
    }

    public function index()
    {
        echo 2222;
         die('1111');
    }
    public function __destruct(){
        echo 'destruct';

    }

    public function detail()
    {
        $data = $this->feed->getFeedByKey(Request::segment(2));
        var_dump($data);
    }

    public function add()
    {
        list($ok,$data,$msg) = $this->feed->create($_POST);
        var_dump($data);
        exit;
    }

    public function get()
    {

        $data = $this->feed->getFeedByKey('jfecsbCvU6aT');
        var_dump($data);
    }
}