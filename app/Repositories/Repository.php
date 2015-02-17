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
    static $model_namespace_prefix = "\\App\Models\\";//model命名空间
    static $add_validator_rules    = [];//添加验证规则
    static $edit_validator_rules   = [];//编辑验证规则
    static $validator_messages     = [];//验证提示信息

    private $trees=array();

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
        return [true, $data, $msg];
    }

    /**
     * 失败返回
     *
     * @param       $msg
     * @param array $data
     *
     * @return array
     */
    public static function fail($msg, $data = array())
    {
        return [false, $data, $msg];
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
            return self::fail($validator->messages()->first());
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
            return method_exists($data, 'toArray') ? $data->toArray() : array();
        }

        return $data;
    }

    /**
     * 获取列表
     * @param array $filter
     * @param int $page_size
     * @param array $sort
     * @return mixed
     */
    public function getDataList($filter = array(), $page_size = 20, $sort = array())
    {
        $full_model_name        = static::$model_namespace_prefix . static::$model_name;
        $model                  = new $full_model_name;
        $paginate               = $model->paginate($page_size);
        $result['current_page'] = $paginate->currentPage();
        $result['total']        = $paginate->total();
        $result['last_page']    = $paginate->lastPage();
        $result['items']        = $model->get()->toArray();
        return $result;
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
        list($ok, , $msg) = self::formatValidator($this->addValidation($data));
        if (!$ok) {
            return self::fail($msg);
        }
        return self::success($data);
    }

    /**
     * 添加操作
     * @param $data
     * @return array
     */
    public function add($data)
    {
        list($ok, $data, $msg) = $this->beforeAdd($data);
        if (!$ok) {
            return self::fail($msg);
        }
        $model = $this->callModelFunction('create', $data);
        if (!$model) {
            return self::fail('创建失败');
        }
        list($ok, , $msg) = $this->afterAdd($model);
        if (!$ok) {
            return self::fail($msg);
        }
        return self::success();
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
        return self::success('创建成功');
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
    public function beforeEdit($id,$data)
    {
        list($ok, , $msg) = self::formatValidator($this->editValidation($data));
        if (!$ok) {
            return self::fail($msg);
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
        list($ok, $data, $msg) = $this->beforeEdit($id,$data);
        if (!$ok) {
            return self::fail($msg);
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
        list($ok, , $msg) = $this->afterEdit($model);
        if (!$ok) {
            return self::fail($msg);
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
        if ($model->delete_time != null) {
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
        list($ok, $model, $msg) = $this->beforeDelete($model);
        if (!$ok) {
            return self::fail($msg);
        }
        $model->delete_time = date('Y-m-d H:i:s');
        $model->status      = -1;
        if (!$model->save()) {
            return self::fail('删除失败');
        }
        list($ok, , $msg) = $this->afterDelete($model);
        if (!$ok) {
            return self::fail($msg);
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


    public function buildTree($tree)
    {
        foreach($tree as $t){
            $this->trees;
        }
    }

}