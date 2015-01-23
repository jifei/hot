<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:53
 */
namespace App\Http\Controllers;

use App\Repositories\Feed\FeedRepository;
use App\Repositories\Feed\UpDownRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class FeedController extends Controller
{
    public function __construct(FeedRepository $feed)
    {
        $this->feed = $feed;
        $this->middleware('auth', ['only' => ['add', 'up', 'down']]);
    }

    public function index()
    {
        $feed_list = $this->feed->getFeedList(Input::get('1'), 'fid', 50);

        return view('home', array('feed_list' => $feed_list));
    }

    /**
     * up
     * @return mixed
     */
    public function up()
    {
      return $this->up_or_down(UpDownRepository::DIRECTION_UP);
    }

    /**
     * down
     * @return mixed
     */
    public function down()
    {
        return $this->up_or_down(UpDownRepository::DIRECTION_DOWN);
    }

    /**
     * up or down
     * @param int              $direction
     * @param UpDownRepository $upDown
     *
     * @return mixed
     */
    private function up_or_down($direction = UpDownRepository::DIRECTION_UP, UpDownRepository $upDown)
    {
        if ($this->login_user && Request::ajax()) {
            if ($direction == UpDownRepository::DIRECTION_UP) {
                list($ok, $data, $msg) = $upDown->feedUp($this->login_user->uid, Input::get('fkey'));
            } else {
                list($ok, $data, $msg) = $upDown->feedDown($this->login_user->uid, Input::get('fkey'));
            }
            if(!$ok){
                return self::ajaxFail($msg);
            }
            return self::ajaxSuccess($data);
        }
        return self::ajaxFail('非法操作');
    }

    public function detail()
    {
        $data = $this->feed->getFeedByKey(Request::segment(2));
        var_dump($data);
    }

    public function add()
    {
        list($ok, $data, $msg) = $this->feed->create($_POST);
        if (!$ok) {
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