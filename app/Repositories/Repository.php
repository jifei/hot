<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/28
 * Time: 13:37
 */
namespace App\Repositories;

use Validator;

class Repository
{
    const FORMAT_OBJECT = 'object';//格式化数据为对象
    const FORMAT_ARRAY  = 'array';//格式化数据为数组
    static $model_name             = '';//model名称
    static $model_namespace_prefix = "\\App\\Models\\";//model命名空间
    static $add_validator_rules    = [];//添加验证规则
    static $edit_validator_rules   = [];//编辑验证规则
    static $validator_messages     = [];//验证提示信息
    static $order_fields           = [];//允许排序字段
    static $order_directions       = ['asc', 'desc'];//允许排序方向
    const CODE_SUCCESS      = 200;
    const CODE_FAIL         = 400;
    const CODE_UNAUTHORIZED = 401;//权限验证失败
    const CODE_FORBIDDEN    = 403;//拒绝执行
    const CODE_NO_DATA      = 404;//数据不存在
    const CODE_ERROR_PARAM  = 405;//参数错误
    const CODE_MISS_PARAM   = 406;//参数不全
    const CODE_TIMEOUT      = 408;//超时
    const PAGE_SIZE         = 20;
    private $trees = array();

    /**
     * 调用model function
     * @param $function
     * @param null $parameter
     * @param null $model_name
     * @return mixed|null
     */
    public function callModelFunction($function, $parameter = null, $model_name = null)
    {
        if ($model_name == null) {
            $model_name = static::$model_name;
        }
        if (!$model_name) {
            return null;
        }
        $full_model_name = static::$model_namespace_prefix . $model_name;
        if (!class_exists($full_model_name)) {
            return null;
        }
        return call_user_func($full_model_name . '::' . $function, $parameter);

    }

    /**
     * 获取一条model
     * @param $id
     * @param null $model_name
     * @return mixed|null
     */
    public function getModel($id, $model_name = null)
    {
        return $this->callModelFunction('find', $id, $model_name);
    }

    /**
     * 成功返回
     *
     * @param array $data
     * @param string $msg
     *
     * @return array
     */
    public static function success($data = array(), $msg = 'ok')
    {
        return [200, $data, $msg];
    }

    /**
     * 失败返回
     *
     * @param       $msg
     * @param       $code //错误代码
     * @param array $data
     *
     * @return array
     */
    public static function fail($msg, $code = 400, $data = array())
    {
        return [$code, $data, $msg];
    }


    /**
     * 格式化输出验证器
     *
     * @param Validator $validator
     *
     * @return array
     */
    public static function formatValidator($validator)
    {
        if ($validator->fails()) {
            return self::fail($validator->messages()->first(), self::CODE_ERROR_PARAM);
        }

        return self::success();
    }

    /**
     * 输出指定格式
     *
     * @param        $data
     * @param string $format
     *
     * @return array
     */
    public static function formatResult($data, $format = self::FORMAT_ARRAY)
    {
        if ($format == 'array') {
            return method_exists($data, 'toArray') ? $data->toArray()
                : ($data ? json_decode(json_encode($data), true) : array());
        }

        return $data;
    }

    /**
     * 获取之前操作
     * @param $filter
     * @param $model
     * @return mixed
     */
    public function beforeGet($filter, $model)
    {
        return $model;
    }

    /**
     * 设置排序
     * @param $model
     * @param $sort
     * @return mixed
     */
    public function setOrder($model, $sort = array())
    {
        if (!empty($sort)) {
            foreach ($sort as $k => $v) {
                if (in_array($k, static::$order_fields) && in_array($v, static::$order_directions)) {
                    $model = $model->orderBy($k, $v);
                }
            }
        }
        return $model;
    }

    /**
     * 获取列表
     * @param array $filter
     * @param int $page_size
     * @param array $sort
     * @return mixed
     */
    public function getDataList($filter = array(), $page_size = self::PAGE_SIZE, $sort = array())
    {
        $full_model_name        = static::$model_namespace_prefix . static::$model_name;
        $model                  = new $full_model_name;
        $model                  = $this->beforeGet($filter, $model);
        $paginate               = $model->paginate($page_size);
        $result['current_page'] = $paginate->currentPage();
        $result['total']        = $paginate->total();
        $result['last_page']    = $paginate->lastPage();
        $result['page_size']    = $page_size;
        $model                  = $this->setOrder($model, $sort);
        $result['items']        = $model->get()->toArray();
        return $result;
    }


    /****
     *
     * APP返回分页数据格式
     *
     * @param $list     array "分页数据数组"
     * @param $page     int "当前第X页"
     * @param $is_end   int "是否结束(0已结束1未结束)"
     * @param $page_num int "每页条数"
     * @param $ext      array "其它信息"
     * @return array
     */
    public function getApiPageList($list, $page, $is_end, $page_num, $ext = array())
    {
        $format = array(
            'list'     => (array)$list,
            'page'     => intval($page),
            'is_end'   => intval($is_end),
            "page_num" => intval($page_num),
        );

        return array_merge((array)$ext, $format);
    }

    public function addValidation($data)
    {
        return Validator::make($data, static::$add_validator_rules, static::$validator_messages);
    }

    /**
     * 添加前预处理操作
     * @param $data
     * @return array
     */
    public function beforeAdd($data)
    {
        list($code, , $msg) = self::formatValidator($this->addValidation($data));
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        return self::success($data);
    }

    /**
     * 添加操作
     * @param $data
     * @param $format
     * @return array
     */
    public function add($data, $format = self::FORMAT_ARRAY)
    {
        list($code, $data, $msg) = $this->beforeAdd($data);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        $model = $this->callModelFunction('create', $data);
        if (!$model) {
            return self::fail('创建失败');
        }
        list($code, , $msg) = $this->afterAdd($model);
        if ($code != 200) {
            return self::fail($msg);
        }
        return self::success(self::formatResult($model, $format));
    }

    /**
     * 是否model对象
     * @param $model
     * @return bool
     */
    public function isModelObject($model)
    {
        if (!($model instanceof \App\Models\BaseModel)) {
            return false;
        }
        return true;
    }

    /**
     * 添加后操作
     * @param $model
     * @return array
     */
    public function afterAdd($model)
    {
        if (!$this->isModelObject($model)) {
            return self::fail('创建失败');
        }
        return self::success($model, '创建成功');
    }

    /**
     * 编辑验证
     * @param $data
     * @return mixed
     */
    public function editValidation($data)
    {
        return Validator::make($data, static::$edit_validator_rules, static::$validator_messages);
    }

    /**
     * 编辑前操作
     * @param $id
     * @param $data
     * @return array
     */
    public function beforeEdit($id, $data)
    {
        list($code, , $msg) = self::formatValidator($this->editValidation($data));
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        if (isset($data['status'])) {
            if ($data['status'] != -1) {
                $data['delete_time'] = null;
            } else {
                $data['delete_time'] = date('Y-m-d H:i:s');
            }
        }
        return self::success($data);
    }

    /**
     * 编辑操作
     * @param $id
     * @param $data
     * @return array
     */
    public function edit($id, $data)
    {
        list($code, $data, $msg) = $this->beforeEdit($id, $data);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        $model = $this->getModel($id);
        if (!$model) {
            return self::fail('记录不存在');
        }
        if (!empty($model->delete_time) && !empty($data['delete_time'])) {
            unset($data['delete_time']);
        }
        if (!$model->update($data)) {
            return self::fail('更新失败');
        }
        //编辑成功后操作
        list($code, , $msg) = $this->afterEdit($model);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        return self::success('更新成功');
    }

    /**
     * 编辑后操作
     * @param $model
     * @return array
     */
    public function afterEdit($model)
    {
        return self::success();
    }


    /**
     * 删除前操作
     * @param $model
     * @return array
     */
    public function beforeDelete($model)
    {
        if (!$this->isModelObject($model)) {
            return self::fail('记录不存在');
        }
//        if (!isset($model->delete_time)) {
//            return self::fail('缺少delete_time字段');
//        }
        if ($model->delete_time == -1) {
            return self::fail('已经删除无须重复删除');
        }
        return self::success($model);
    }

    /**
     * 删除操作
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $model = $this->getModel($id);
        if (!$model) {
            return self::fail('记录不存在');
        }
        list($code, $model, $msg) = $this->beforeDelete($model);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        $model->delete_time = date('Y-m-d H:i:s');
        $model->status      = -1;
        if (!$model->save()) {
            return self::fail('删除失败');
        }
        list($code, , $msg) = $this->afterDelete($model);
        if ($code != 200) {
            return self::fail($msg, $code);
        }
        return self::success('删除成功');

    }

    /**
     * 删除后操作
     * @param $model
     * @return array
     */
    public function afterDelete($model)
    {
        return self::success();
    }


}