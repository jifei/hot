<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/1/22
 * Time: 20:43
 */
namespace App\Repositories\Feed;

use App\Models\UpDown;
use App\Repositories\Repository;
use App\Repositories\Feed;

class UpDownRepository extends Repository
{
    const DIRECTION_UP = 1;//up
    const DIRECTION_DOWN = -1;//down

    private static $directions = array(self::DIRECTION_UP, self::DIRECTION_DOWN);

    public function __construct(FeedRepository $feed)
    {
        $this->feed = $feed;
    }

    /**
     * 获取
     *
     * @param        $uid
     * @param        $fid
     * @param string $format
     *
     * @return array
     */
    public function getUpDown($uid, $fid, $format = self::FORMAT_ARRAY)
    {
        $feed = UpDown::where('fid', $fid)->where('uid', $uid)->where('status', 1)->first();

        return self::format_result($feed, $format);
    }

    /**
     * up
     *
     * @param $uid
     * @param $fkey
     *
     * @return array
     */
    public function feedUp($uid, $fkey)
    {
        return $this->create(array('uid' => $uid, 'fkey' => $fkey, 'direction' => self::DIRECTION_UP));
    }


    /**
     * down
     *
     * @param $uid
     * @param $fkey
     *
     * @return array
     */
    public function feedDown($uid, $fkey)
    {
        return $this->create(array('uid' => $uid, 'fkey' => $fkey, 'direction' => self::DIRECTION_DOWN));
    }

    /**
     * 创建
     *
     * @param        $data
     * @param string $format
     *
     * @return array
     */
    private function create($data, $format = self::FORMAT_ARRAY)
    {
        if (empty($data['uid']) || empty($data['fkey']) || empty($data['direction'])) {
            return self::fail('缺少参数');
        }
        if (!in_array($data['direction'], self::$directions)) {
            return self::fail('操作不存在');
        }
        $feed = $this->feed->getFeedByKey($data['fkey'], self::FORMAT_OBJECT);
        if (!$feed) {
            return self::fail('热度点不存在');
        }
        $data['fid'] = $feed->fid;
        if ($feed->uid == $data['uid']) {
            return self::fail('自己不能操作');
        }
        $upDown = $this->getUpDown($data['uid'], $data['fid'], self::FORMAT_OBJECT);
        //已经操作过
        if ($upDown) {
            //减少原来操作
            if ($upDown->direction == self::DIRECTION_DOWN) {
                --$feed->down_num;
            } else {
                --$feed->up_num;
            }
            //反向操作，增加现在操作
            if ($upDown->direction != $data['direction']) {
                if ($upDown->direction == self::DIRECTION_DOWN) {
                    ++$feed->up_num;
                } else {
                    ++$feed->down_num;
                }
            }
            $upDown->status = -1;
            $upDown->save();

        } else {//未操作过
            if ($data['direction'] == self::DIRECTION_DOWN) {
                ++$feed->down_num;
            } else {
                ++$feed->up_num;
            }
        }
        $feed->save();

        $data['status'] = 1;
        $ret            = UpDown::create($data);
        if (!$ret) {
            return self::fail('操作失败');
        }

        return self::success(self::format_result($ret, $format));
    }
}