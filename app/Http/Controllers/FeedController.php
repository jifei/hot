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
use Auth;

class FeedController extends Controller
{
    public function __construct(FeedRepository $feed)
    {
        $this->feed = $feed;
        $this->middleware('auth', ['only' => ['add']]);
    }

    public function index()
    {
        $this->feed->getFeedList(Input::get('1'),11,50);
    }
    public function detail()
    {
        $data = $this->feed->getFeedByKey(Request::segment(2));
        var_dump($data);
    }

    public function add()
    {
        list($ok,$data,$msg) = $this->feed->create($_POST);
        if(!$ok){
            return $this->ajaxFail($msg);
        }
        return $this->ajaxSuccess($data);
    }

    public function get()
    {

        $data = $this->feed->getFeedByKey('jfecsbCvU6aT');
        var_dump($data);
    }
}