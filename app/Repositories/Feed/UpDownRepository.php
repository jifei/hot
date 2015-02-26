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
     * @param array  $filter
     * @param string $format
     *
     * @return array
     */
    public function getUpDown($uid, $fid, $filter = array(), $format = self::FORMAT_ARRAY)
    {
        $up_down = UpDown::where('fid', $fid)->where('uid', $uid);
        if (!empty($filter['direction'])) {
            $up_down->where('direction', $filter['direction']);
        }
        if (isset($filter['status'])) {
            $up_down->where('status', $filter['status']);
        } else {
            $up_down->where('status', 1);
        }
        $ret = $up_down->orderBy('id', 'desc')->first();

        return self::formatResult($ret, $format);
    }

    /**
     * 用户单条操作次数
     *
     * @param $uid
     * @param $fid
     *
     * @return mixed
     */
    public function userFeedUpDownNum($uid, $fid)
    {
        return UpDown::where('fid', $fid)->where('uid', $uid)->count();
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
        $up_down = $this->getUpDown($data['uid'], $data['fid'], array('status' => 1), self::FORMAT_OBJECT);
        //已经操作过
        if ($up_down) {
            $operate_num = $this->userFeedUpDownNum($data['uid'], $data['fid']);
            if ($operate_num > 10) {
                return self::fail('抱歉，您操作的次数过多');
            }
            //相同操作
            if ($up_down->direction == $data['direction']) {
                if ($up_down->direction == self::DIRECTION_DOWN) {
                    --$feed->down_num;
                } else {
                    --$feed->up_num;
                }
            } //反向操作
            else if ($up_down->direction != $data['direction']) {
                if ($up_down->direction == self::DIRECTION_DOWN) {
                    ++$feed->up_num;
                    --$feed->down_num;
                } else {
                    ++$feed->down_num;
                    --$feed->up_num;
                }
                UpDown::create($data);
            }
            $up_down->status = -1;
            $up_down->save();

        } else {//未操作过
            if ($data['direction'] == self::DIRECTION_DOWN) {
                ++$feed->down_num;
            } else {
                ++$feed->up_num;
            }
            UpDown::create($data);
        }
        $feed->save();

        $result = array('up_num' => $feed->up_num, 'down_num' => $feed->down_num);

        return self::success($result);
    }
}