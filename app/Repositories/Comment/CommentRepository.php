<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/27
 * Time: 01:03
 */
namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\Repository;
use App\Repositories\Feed\FeedRepository;


class CommentRepository extends Repository
{

    public function __construct(FeedRepository $feed)
    {
        $this->feed = $feed;
    }


    /**
     * 添加数据
     *
     * @param $uid
     * @param $fkey
     * @param $ext
     * @param $format
     *
     * @return array
     */
    public function create($uid, $fkey, $ext, $format = self::FORMAT_ARRAY)
    {
        $data['uid'] = $uid;
        if (empty($ext['content'])) {
            return self::fail('评论内容不能为空');
        }
        if (mb_strlen($ext['content'], 'utf-8') > 200) {
            return self::fail('评论长度过长');
        }
        $data['content'] = $ext['content'];
        $feed            = $this->feed->getFeedByKey($fkey, self::FORMAT_OBJECT);
        if (!$feed || $feed->status != 1) {
            return self::fail('热度点不存在');
        }
        $data['fid']    = $feed->fid;
        $data['status'] = 1;
        $ret            = Comment::create($data);

        return self::success(self::format_result($ret, $format));
    }

}
