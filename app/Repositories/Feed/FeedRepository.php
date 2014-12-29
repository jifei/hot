<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/27
 * Time: 01:03
 */
namespace App\Repositories\Feed;

use App\Models\Feed;
use App\Repositories\Repository;
use Validator;



class FeedRepository extends Repository
{
    public function __construct()
    {
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
           // 'title.required' => '热点不能为空!',
            //'title.min'      => '热点长度偏短',
            //'title.max'      => '热点长度过长',
            'uid.required'   => '非法用户',
            'bid.required'   => '版块非法',
            'uid.integer'    => '非法用户!',
            'bid.integer'    => '版块非法',
        ];

        //验证规则
        $rules = [
           // 'title' => 'required|min:4|max:360',
            'uid'   => 'required|integer',
            'bid'   => 'required|integer',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 添加数据
     * @param $data
     *
     * @return array
     */
    public function create($data)
    {
        list($ok, , $msg) = self::format_validator($this->validator($data));
        if (!$ok) {
            return self::fail($msg);
        }
        if (!empty($data['link']) && !filter_var($data['link'], FILTER_VALIDATE_URL)) {
           return self::fail('链接地址错误');
        }
        $data['fkey']   = generate_feed_key();
        $data['status'] = 1;
        $ret=Feed::create($data);
        return self::success($ret->toArray());
    }


}
