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
use App\Models\HashtagFeed;
use App\Repositories\Repository;
use App\Repositories\Board\BoardRepository;
use Validator;
use Auth;
use DB;
use PDO;
use App\Repositories\Feed\UpDownRepository;


class FeedRepository extends Repository
{

    private $hashtags = array();

    public function __construct(BoardRepository $board)
    {
        $this->board = $board;
    }

    private function parseFeed($feed)
    {
        $feed = htmlspecialchars($feed, ENT_QUOTES);

        return preg_replace_callback(
            "/([^A-Za-z0-9_\x{4e00}-\x{9fa5}]#|^#)([#A-Za-z0-9_\x{4e00}-\x{9fa5}]+)/u",
            function ($matches) {
                if (stripos($matches[2], '#') !== false) {
                    return $matches[0];
                }

                $this->hashtags[] = $matches[2];

                return substr($matches[1], 0, -1) . "<a href=\"/hashtag/" . $matches[2] . "?source=feed\"><s>#</s><b>" . $matches[2] . "</b></a>";
            },
            $feed);
    }

    private function unique_hashtag()
    {
        $this->hashtags = array_unique($this->hashtags);
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
            'title.required' => '热度点不能为空!',
            'title.min'      => '热度点长度偏短',
            'title.max'      => '热度点长度过长',
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


    private function afterCreateFeed($feed)
    {
        if ($feed) {
            //话题
            if (count($this->hashtags) > 0) {
                $this->unique_hashtag();
                foreach ($this->hashtags as $hashtag) {
                    HashtagFeed::create(array('hashtag' => $hashtag, 'fid' => $feed->fid, 'uid' => $feed->uid));
                }
            }
        }
    }

    /**
     * 添加数据
     *
     * @param $data
     * @param $format
     *
     * @return array
     */
    public function create($data, $format = self::FORMAT_ARRAY)
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
        $data['title']  = $this->parseFeed($data['title']);
        $data['fkey']   = generate_feed_key();
        $data['status'] = 1;
        $ret            = Feed::create($data);
        //创建成功后续操作
        $this->afterCreateFeed($ret);

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
    public function getFeedByKey($key, $format = self::FORMAT_ARRAY)
    {
        $feed = Feed::where('fkey', $key)->first();

        return self::format_result($feed, $format);
    }

    /**
     * 详细
     *
     * @param $key
     *
     * @return array
     */
    public function getFeedDetail($key)
    {
        $feed = $this->getFeedByKey($key, self::FORMAT_OBJECT);
        $ret  = array();
        if ($feed) {
            $ret               = $feed->toArray();
            $ret['nickname']   = $feed->user->nickname;
            $ret['board_name'] = $feed->board->name;
            $ret['board_code'] = $feed->board->code;
        }

        return $ret;

    }

    /**
     * 获取热度点列表
     *
     * @param        $filter
     * @param string $order
     * @param int    $page
     * @param int    $page_size
     *
     * @return array
     */
    public function getFeedList($filter, $order = 'fid', $page = 1, $page_size = 50)
    {
        $page = max(1, min(20, intval($page)));
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $query = DB::table('feed as f')->select('f.fkey', 'f.title', 'f.domain', 'f.up_num', 'f.down_num',
            'f.created_at', 'u.nickname', 'b.name as board_name', 'b.code as board_code');
        $query->leftJoin('user as u', 'f.uid', '=', 'u.uid');
        $query->leftJoin('board as b', 'f.bid', '=', 'b.bid');

        if (!empty($filter['board'])) {
            $board = $this->board->getBoardByCode($filter['board']);
            if (!empty($board['bid'])) {
                $query->where('f.bid', $board['bid']);
            }
        }
        if (!in_array($order, ['fid'])) {
            $order = 'fid';
        }
        $query->where('f.status', 1);
        $query->orderBy('f.' . $order, 'DESC');
        $query->skip(($page - 1) * $page_size)->take($page_size);

        return $query->get();
    }


    public function getFeedByBoard($bid, $order, $format = self::FORMAT_ARRAY)
    {
        $feed = Feed::where('bid', $bid)->orWhere('pid', $bid)->orderBy($order, 'DESC')->get();

        return self::format_result($feed, $format);
    }


}
