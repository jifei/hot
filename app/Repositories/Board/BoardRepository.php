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
        return self::format_result(Board::where('code', $code)->first(), $format);
    }

    public function searchBoards($keyword = '', $format = 'array')
    {
        if ($keyword === '') {
            return $this->getTopBoards($format);
        }
        return self::format_result(Board::where('status',1)
            ->where(function($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%")->orWhere('code', 'like', "%$keyword%");
            })->orderBy('display_sort', 'ASC')->orderBy('bid', 'ASC')->get(), $format);
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
        /*return $data = [
            ['id' => '1', 'name' => '新闻', 'code' => 'news', 'display_sort' => 1],
            ['id' => '2', 'name' => '原创', 'code' => 'funny', 'display_sort' => 2],
            ['id' => '2', 'name' => '观点', 'code' => 'funny', 'display_sort' => 2],
            ['id' => '2', 'name' => '搞笑', 'code' => 'funny', 'display_sort' => 2],
            ['id' => '4', 'name' => '娱乐', 'code' => 'ent', 'display_sort' => 4],
            ['id' => '6', 'name' => '影视', 'code' => 'yingshi', 'display_sort' => 6],
            ['id' => '7', 'name' => '生活', 'code' => 'life', 'display_sort' => 7],
            ['id' => '17', 'name' => '活动', 'code' => 'activity', 'display_sort' => 17],
            ['id' => '18', 'name' => '优惠', 'code' => 'youhui', 'display_sort' => 18],
            ['id' => '8', 'name' => '美女', 'code' => 'meinv', 'display_sort' => 8],
            ['id' => '5', 'name' => '情感', 'code' => 'emotion', 'display_sort' => 5],
            ['id' => '9', 'name' => '科技', 'code' => 'tech', 'display_sort' => 9],
            ['id' => '16', 'name' => 'IT', 'code' => 'it', 'display_sort' => 9],
            ['id' => '16', 'name' => '职业', 'code' => 'it', 'display_sort' => 9],
            ['id' => '10', 'name' => '财经', 'code' => 'finance', 'display_sort' => 10],
            ['id' => '11', 'name' => '体育', 'code' => 'sports', 'display_sort' => 11],
            ['id' => '12', 'name' => '游戏', 'code' => 'game', 'display_sort' => 12],
            ['id' => '13', 'name' => '汽车', 'code' => 'auto', 'display_sort' => 13],
            ['id' => '14', 'name' => '教育', 'code' => 'edu', 'display_sort' => 14],
            ['id' => '14', 'name' => '声明', 'code' => 'statement', 'display_sort' => 14],
            ['id' => '15', 'name' => '公益', 'code' => 'gongyi', 'display_sort' => 15],
            ['id' => '16', 'name' => '建议', 'code' => 'gongyi', 'display_sort' => 15],
        ];*/

        return self::format_result(Board::where('pid', 0)->orderBy('display_sort', 'ASC')->orderBy('bid', 'ASC')->get(), $format);
    }

} 