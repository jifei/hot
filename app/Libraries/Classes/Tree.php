<?php
namespace App\Libraries\Classes;
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/15
 * Time: 下午1:21
 */
class Tree
{
    private $original_list;//所有的
    private $selected_keys;//选中的
    public  $pk;//pk
    public  $parent_key;//上级ID
    public  $children_key;//存放子孙的key名
    public  $current_id;//当前ID

    function __construct($pk = 'id', $parent_key = 'pid', $children_key = 'children')
    {
        if (!empty($pk) && !empty($parent_key) && !empty($children_key)) {
            $this->pk           = $pk;
            $this->parent_key   = $parent_key;
            $this->children_key = $children_key;
        }
    }

    /**
     * 装载数据
     * @param $data
     * @param null $allowed_data
     * @param array $selected_keys
     */
    public function load($data, $allowed_data = null, $selected_keys = array())
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $v['id']                            = $v[$this->pk];
                $v['text']                          = isset($v['name']) ? $v['name'] : (isset($v['title']) ? $v['title'] : '');
                $this->original_list[$v[$this->pk]] = $v;
            }
            if (is_array($allowed_data) && !empty($allowed_data)) {
                foreach ($allowed_data as $k => $v) {
                    $this->allowFromChild($v);
                }
            }
            $this->selected_keys = $selected_keys;
        }
    }

    /**
     * 建立树结构
     * @param int $root
     * @return array|bool
     */
    public function buildTree($root = 0)
    {
        if (!$this->original_list) {
            return false;
        }
        $original_list = $this->original_list;
        $tree          = array();//result
        $refer         = array();//主键和单元引用
        foreach ($original_list as $k => $v) {
            if (!isset($v[$this->pk]) || !isset($v[$this->parent_key]) || isset($v[$this->children_key])) {
                unset($original_list[$k]);
                continue;
            }
            //选中
            if (in_array($v[$this->pk], $this->selected_keys)) {
                $original_list[$k]['state']['selected'] = true;
            }
            $refer[$v[$this->pk]] =& $original_list[$k];
        }

        foreach ($original_list as $k => $v) {
            if ($v[$this->parent_key] == $root) {//根直接添加到树中
                $tree[] =& $original_list[$k];
            } else {
                if (isset($refer[$v[$this->parent_key]])) {
                    $parent                        =& $refer[$v[$this->parent_key]];//获取父分类的引用
                    $parent[$this->children_key][] =& $original_list[$k];//在父分类的children中再添加一个引用成员
                }
            }
        }
        return $tree;
    }


    /**
     * 授权
     * @param $child
     */
    public function  allowFromChild($child)
    {
        if (empty($this->original_list[$child[$this->pk]]['is_allowed'])) {
            $this->original_list[$child[$this->pk]]['is_allowed'] = 1;
            if (!empty($this->original_list[$child[$this->parent_key]])) {
                $this->allowFromChild($this->original_list[$child[$this->parent_key]]);
            }
        }
    }

    /**
     * 输出树结构
     * @param $tree
     */
    public function printTree($tree)
    {
        if (is_array($tree) && count($tree) > 0) {
            echo '<ul>';
            foreach ($tree as $node) {
                echo '<li>' . $node['text'];
                if (!empty($node['children']))
                    $this->printTree($node['children']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }


    /**
     * 输出允许的树结构
     * @param $tree
     * @param $is_root
     */
    public function printAllowedTree($tree,$is_root=0)
    {
        if (is_array($tree) && count($tree) > 0) {
            echo $is_root==0?'<ul  class="treeview-menu">':'';
            foreach ($tree as $node) {
                if (empty($node['is_allowed'])) {
                    continue;
                }
                $has_children = !empty($node['children']) ? true : false;
                $active =$node[$this->pk]==$this->current_id?' active':'';
                echo '<li '.($has_children?'class="treeview'.$active.'"':'').'><a href="'.$node['url'].'"><i class="fa fa-circle-o"></i><span>' . $node['text'] . '</span></a>';
                if ($has_children)
                    $this->printAllowedTree($node['children']);
                echo '</li>';
            }
            echo  $is_root==0?'</ul>':'';
        }
    }

    public function printSelectedTree($tree)
    {
        if (is_array($tree) && count($tree) > 0) {
            echo '<ul>';
            foreach ($tree as $node) {
                if (empty($node['is_allowed'])) {
                    continue;
                }
                $selected = !empty($node['state']['selected']) ? 'checked' : '';
                echo "<li><input type=\"checkbox\" $selected>" . $node['text'];
                if (!empty($node['children']))
                    $this->printSelectedTree($node['children']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }
}

