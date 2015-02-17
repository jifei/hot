<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    const CREATED_AT = 'add_time';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'update_time';

    static $status_map       = array(1 => '正常', 0 => '暂停', '-1' => '已删除');
    static $status_color_map = array(1 => 'green', 0 => 'orange', -1 => 'red');

    public function toArray()
    {
        $array = parent::toArray();
        if (isset($array['status'])) {
            $array['status_name']       = isset(static::$status_map[$array['status']]) ? static::$status_map[$array['status']] :
                (isset(self::$status_map[$array['status']]) ? self::$status_map[$array['status']] : '');
            $array['status_color_name'] = addTextColor($array['status_name'], isset(static::$status_color_map[$array['status']]) ? static::$status_color_map[$array['status']] :
                (isset(self::$status_color_map[$array['status']]) ? self::$status_color_map[$array['status']] : ''));
        }
        if (isset($array['delete_time'])) {
            $array['delete_time_color'] = !empty($array['delete_time']) ? addTextColor($array['delete_time'], 'red') : '';
        }
        return $array;
    }

}
