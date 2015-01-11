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


class FeedRepository extends Repository
{
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
     * @param        $filter
     * @param        $order
     * @param int    $limit
     * @param string $format
     *
     * @return array
     */
    public function getFeedList($filter, $order, $limit = 50, $format = 'array')
    {
        $query =DB::table('feed');
        if (!empty($filter['board'])) {
            $board = $this->board->getBoardByName($filter['board']);
            if (!empty($board['bid'])) {
                $query = $query->where('bid', $board['bid']);
            }
        }
        if(!in_array($order,['fid','',''])){
           $order = 'fid';
        }
        return self::format_result($query->where('status',1)->orderBy($order, 'DESC')->limit($limit)->get(),$format);
    }

    public function getFeedByBoard($bid, $order, $format = 'array')
    {
        $feed = Feed::where('bid', $bid)->orWhere('pid', $bid)->orderBy($order, 'DESC')->get();

        return self::format_result($feed, $format);
    }


}
