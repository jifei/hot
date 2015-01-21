<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/27
 * Time: 01:03
 */
namespace App\Repositories\Feed;

use App\Models\Board;
use App\Models\Feed;
use App\Repositories\Repository;
use App\Repositories\Board\BoardRepository;
use Validator;
use Auth;
use DB;
use PDO;


class FeedRepository extends Repository
{
    const DIRECTION_UP = 1;//up
    const DIRECTION_DOWN = -1;//down
    const OPERATE_ADD = 1;//添加
    const OPERATE_CANCEL = -1;//取消

    public function __construct(BoardRepository $board)
    {
        $this->board = $board;
    }

    public function all()
    {
        return Feed::all();
        //$this->user::findAll(1);
    }

    public function validator(array $data)
    {
        //验证提示信息
        $messages = [
            'title.required' => '热点不能为空!',
            'title.min'      => '热点长度偏短',
            'title.max'      => '热点长度过长',
            'uid.required'   => '非法用户',
            'bid.required'   => '版块非法',
            'uid.integer'    => '非法用户!',
            'bid.integer'    => '版块非法',
            'link.url'       => '链接地址错误',
        ];

        //验证规则
        $rules = [
            'title' => 'required|min:4|max:360',
            'uid'   => 'required|integer',
            'bid'   => 'required|integer',
            'link'  => 'url',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 添加数据
     *
     * @param $data
     * @param $format
     *
     * @return array
     */
    public function create($data, $format = 'array')
    {
        $data['uid'] = Auth::user()->uid;
        if (empty($data['board'])) {
            return self::fail('版块名称不能为空');
        }
        $board = $this->board->getBoardByName($data['board']);
        if (empty($board['bid'])) {
            return self::fail('该版块不存在');
        }
        $data['bid'] = $board['bid'];
        if (!empty($data['link']) && stripos($data['link'], 'http') === false) {
            $data['link'] = 'http://' . $data['link'];
        }
        list($ok, , $msg) = self::format_validator($this->validator($data));
        if (!$ok) {
            return self::fail($msg);
        }
        if (!empty($data['link'])) {
            $parse_url = parse_url($data['link']);
            if (empty($parse_url['host'])) {
                return self::fail('链接地址错误');
            }
            $data['domain'] = $parse_url['host'];
        }
        $data['fkey']   = generate_feed_key();
        $data['status'] = 1;
        $ret            = Feed::create($data);

        return self::success(self::format_result($ret, $format));
    }

    /**
     * 根据key获取feed
     *
     * @param        $key
     * @param string $format
     *
     * @return array
     */
    public function getFeedByKey($key, $format = 'array')
    {
        $feed = Feed::where('fkey', $key)->first();

        return self::format_result($feed, $format);
    }

    /**
     * 获取热点列表
     *
     * @param        $filter
     * @param        $order
     * @param int    $limit
     * @param string $format
     *
     * @return array
     */
    public function getFeedList($filter, $order, $limit = 50, $format = 'array')
    {
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $query = DB::table('feed as f')->select('f.title', 'f.link', 'f.up_num', 'f.down_num',
            'f.created_at', 'u.nickname', 'b.name as board_name', 'b.code as board_code');
        $query->leftJoin('user as u', 'f.uid', '=', 'u.uid');
        $query->leftJoin('board as b', 'f.bid', '=', 'b.bid');

        if (!empty($filter['board'])) {
            $board = $this->board->getBoardByName($filter['board']);
            if (!empty($board['bid'])) {
                $query->where('f.bid', $board['bid']);
            }
        }
        if (!in_array($order, ['fid', ''])) {
            $order = 'fid';
        }
        $query->orderBy('f.' . $order, 'DESC');

        return $ret = $query->get();
        DB::setFetchMode(PDO::FETCH_CLASS);
        var_dump($ret);
        exit;
        $feed = new Feed();
        $feed->join('user', 'user.uid', '=', 'feed.uid');
        $ret     = $feed->get()->toArray();
        $queries = DB::getQueryLog();
        echo $last_query = end($queries);

        //dd($last_query);

        return $ret;


        $result = $feed->where('feed.status', 1)->orderBy('feed.' . $order, 'DESC')->limit($limit)->get(array('feed.*', 'user.nickname'));

        return self::format_result($result, $format);
    }


    public function feedUp($uid, $code)
    {
        return $this->feedUpDown($uid, $code);
    }

    public function cancelFeedUp($uid, $code)
    {
        return $this->feedUpDown($uid, $code, self::DIRECTION_UP, self::OPERATE_CANCEL);
    }

    public function feedDown($uid, $code)
    {
        return $this->feedUpDown($uid, $code, self::DIRECTION_DOWN);

    }

    public function cancelFeedDown($uid, $code)
    {
        return $this->feedUpDown($uid, $code, self::DIRECTION_DOWN, self::OPERATE_CANCEL);
    }

    private function feedUpDown($uid, $code, $direction = self::DIRECTION_UP, $operate = self::OPERATE_ADD)
    {
        $feed = $this->getFeedByKey($code);
        return array();
    }

    public
    function getFeedByBoard($bid, $order, $format = 'array')
    {
        $feed = Feed::where('bid', $bid)->orWhere('pid', $bid)->orderBy($order, 'DESC')->get();

        return self::format_result($feed, $format);
    }


}
