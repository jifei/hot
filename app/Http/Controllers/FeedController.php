<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:53
 */
namespace App\Http\Controllers;

use App\Repositories\Feed\FeedRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->feed = new FeedRepository();
    }

    public function index()
    {
        echo 1111;
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
        if (array()) {
            die(111);
        }
        $data = $this->feed->getFeedByKey('jfecsbCvU6aT');
        var_dump($data);
    }
}