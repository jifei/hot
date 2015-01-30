<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/29
 * Time: 下午4:09
 */

namespace App\Http\Controllers;

use App\Repositories\Board\BoardRepository;
use App\Repositories\Feed\FeedRepository;
use Input;
use Request;

class BoardController extends Controller
{
    public function __construct(BoardRepository $board, FeedRepository $feed)
    {
        $this->board = $board;
        $this->feed  = $feed;
    }

    public function index()
    {

    }

    public function feed()
    {

        $code  = Request::segment(2);
        $board = $this->board->getBoardByCode($code);
        if (!$board || $board['status'] != 1) {
            view('error.404');
        }
        $top_board = 0;
        if ($board['pid'] == 0) {
            $top_board = $board['bid'];
        } else {
            $top_board = $board['pid'];
        }
        list($page) = self::getPage();
        $page_size = 50;
        $feed_list = $this->feed->getFeedList(array('board' => $code), '', $page, $page_size);

        return view('home', array('feed_list' => $feed_list, 'top_board' => $top_board));

    }

    public function search()
    {
        //DB::enableQueryLog();
        $data = $this->board->searchBoards(Input::get('q', ''));
        // $queries = DB::getQueryLog();
        //dd($queries);
        //echo $last_query = end($queries);
        return $this->ajaxSuccess($data);
    }

    public function add()
    {
        $data = [
            ['pid' => '2', 'name' => '自媒体', 'code' => 'news', 'display_sort' => 1],
            ['pid' => '3', 'name' => '笑话', 'code' => 'funny', 'display_sort' => 2],
            ['pid' => '3', 'name' => '段子', 'code' => 'duanzi', 'display_sort' => 2],
            ['id' => '3', 'name' => '八卦', 'code' => 'bagua', 'display_sort' => 3],
            ['id' => '4', 'name' => '娱乐', 'code' => 'ent', 'display_sort' => 4],
            ['id' => '5', 'name' => '情感', 'code' => 'emotion', 'display_sort' => 5],
            ['id' => '6', 'name' => '影视', 'code' => 'yingshi', 'display_sort' => 6],
            ['id' => '7', 'name' => '生活', 'code' => 'life', 'display_sort' => 7],
            ['id' => '8', 'name' => '美女', 'code' => 'meinv', 'display_sort' => 8],
            ['id' => '9', 'name' => '科技', 'code' => 'tech', 'display_sort' => 9],
            ['id' => '10', 'name' => '财经', 'code' => 'finance', 'display_sort' => 10],
            ['id' => '11', 'name' => '体育', 'code' => 'sports', 'display_sort' => 11],
            ['id' => '12', 'name' => '游戏', 'code' => 'game', 'display_sort' => 12],
            ['id' => '13', 'name' => '汽车', 'code' => 'auto', 'display_sort' => 13],
            ['id' => '14', 'name' => '教育', 'code' => 'edu', 'display_sort' => 14],
            ['id' => '15', 'name' => '公益', 'code' => 'gongyi', 'display_sort' => 15],
        ];
        foreach ($data as $v) {
            $this->board->create($v);
        }
    }
} 