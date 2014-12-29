<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/29
 * Time: 下午4:09
 */

namespace App\Http\Controllers;


class BoardController extends Controller
{

    public function add()
    {
        $data = [
            ['id' => '1', 'name' => '新闻', 'code' => 'news',],
            ['id' => '1', 'name' => '搞笑', 'code' => 'funny',],
            ['id' => '1', 'name' => '八卦', 'code' => 'bagua',],
            ['id' => '1', 'name' => '娱乐', 'code' => 'ent',],
            ['id' => '1', 'name' => '影视', 'code' => 'yingshi',],
            ['id' => '1', 'name' => '生活', 'code' => 'life',],
            ['id' => '1', 'name' => '美女', 'code' => 'meinv',],
            ['id' => '1', 'name' => '科技', 'code' => 'tech',],
            ['id' => '1', 'name' => '财经', 'code' => 'finance',],
            ['id' => '1', 'name' => '体育', 'code' => 'sports',],
            ['id' => '1', 'name' => '游戏', 'code' => 'game',],
            ['id' => '1', 'name' => '汽车', 'code' => 'auto',],
            ['id' => '1', 'name' => '教育', 'code' => 'edu',],
            ['id' => '1', 'name' => '公益', 'code' => 'gongyi',],
        ];
    }
} 