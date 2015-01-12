<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/29
 * Time: 20:49
 */

namespace App\Repositories\Board;

use App\Repositories\Repository;
use App\Models\Board;

class BoardRepository extends Repository
{
    public function validator(array $data)
    {
        //验证提示信息
        $messages = [
            'code.required' => '版块code不能为空',
            'name.required' => '版块名称不能为空',
            'code.min'      => '版块code偏短',
            'code.max'      => '版块code偏长',
            'name.min'      => '版块名称偏短',
            'name.max'      => '版块名称偏长',
            'name.unique'   => '版块名称已存在',
            'code.unique'   => '版块code已存在',
        ];

        //验证规则
        $rules = [
            'code' => 'required|min:9|max:100|unique:board',
            'name' => 'required|min:4|max:100|unique:board',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 创建
     *
     * @param $data
     * @param $format
     *
     * @return array
     */
    public function create($data, $format = 'array')
    {
        list($ok, , $msg) = self::format_validator($this->validator($data));
        if (!$ok) {
            return self::fail($msg);
        }

        $ret = Board::create($data);

        //todo
        return self::success(self);
    }

    /**
     * 根据版块code获取版块信息
     *
     * @param $code
     * @param $format
     *
     * @return array
     */
    public function getBoardByCode($code, $format = 'array')
    {
        return self::format_result(Board::where('code', $code)->where('status',1)->first(), $format);
    }

    /**
     * 搜索版块
     *
     * @param string $keyword
     * @param string $format
     *
     * @return array|mixed
     */
    public function searchBoards($keyword = '', $format = 'array')
    {
        if ($keyword === '') {
            return $this->getTopBoards($format);
        }

        return self::format_result(Board::where('status', 1)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")->orWhere('code', 'like', "$keyword%");
            })->orderBy('display_sort', 'ASC')->orderBy('bid', 'ASC')->get(), $format);
    }

    /**
     * 根据版块名称获取版块
     * @param        $name
     * @param string $format
     *
     * @return array
     */
    public function getBoardByName($name, $format = 'array')
    {
        return self::format_result(Board::where('name', $name)->where('status', 1)->first(), $format);
    }

    /**
     * 获取所有根版块
     *
     * @param $format
     *
     * @return mixed
     */
    public function getTopBoards($format = 'array')
    {
//         $data = [
//            ['bid' => '1', 'name' => '新闻', 'code' => 'news', 'display_sort' => 1],
//            ['bid' => '2', 'name' => '原创', 'code' => 'yuanchuang', 'display_sort' => 2],
//            ['bid' => '3', 'name' => '搞笑', 'code' => 'funny', 'display_sort' => 3],
//            ['bid' => '4', 'name' => '娱乐', 'code' => 'ent', 'display_sort' => 4],
//            ['bid' => '5', 'name' => '影视', 'code' => 'yingshi', 'display_sort' => 5],
//            ['bid' => '6', 'name' => '生活', 'code' => 'life', 'display_sort' => 6],
//            ['bid' => '7', 'name' => '活动', 'code' => 'huodong', 'display_sort' => 7],
//            ['bid' => '8', 'name' => '优惠', 'code' => 'youhui', 'display_sort' => 8],
//            ['bid' => '9', 'name' => '美女', 'code' => 'meinv', 'display_sort' => 9],
//            ['bid' => '10', 'name' => '情感', 'code' => 'ganqing', 'display_sort' => 10],
//            ['bid' => '11', 'name' => '科技', 'code' => 'tech', 'display_sort' => 11],
//            ['bid' => '12', 'name' => 'IT', 'code' => 'it', 'display_sort' => 12],
//            ['bid' => '13', 'name' => '职业', 'code' => 'zhiye', 'display_sort' => 13],
//            ['bid' => '14', 'name' => '财经', 'code' => 'finance', 'display_sort' => 14],
//            ['bid' => '15', 'name' => '体育', 'code' => 'sports', 'display_sort' => 15],
//            ['bid' => '16', 'name' => '游戏', 'code' => 'game', 'display_sort' => 16],
//            ['bid' => '17', 'name' => '汽车', 'code' => 'auto', 'display_sort' => 17],
//            ['bid' => '18', 'name' => '教育', 'code' => 'edu', 'display_sort' => 18],
//            ['bid' => '19', 'name' => '声明', 'code' => 'statement', 'display_sort' => 19],
//            ['bid' => '20', 'name' => '公益', 'code' => 'gongyi', 'display_sort' => 20],
//            ['bid' => '21', 'name' => '建议', 'code' => 'jianyi', 'display_sort' => 21],
//        ];
//        foreach($data as $v){
//            Board::create($v);
//        }
//        ['id' => '16', 'name' => '自媒体', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '观点', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '笑话', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '段子', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '电视剧', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '电影', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '综艺', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '预告片', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '聚会', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '会议', 'code' => 'gongyi', 'display_sort' => 15],
//            ['id' => '16', 'name' => '比赛', 'code' => 'gongyi', 'display_sort' => 15],

        return self::format_result(Board::where('pid', 0)->orderBy('display_sort', 'ASC')->orderBy('bid', 'ASC')->get(), $format);
    }

} 