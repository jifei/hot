<?php namespace App\Models;

class AdminUser extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table      = 'admin_user';
    protected $primaryKey = 'uid';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'real_name', 'avatar', 'mobile', 'email', 'status', 'password', 'delete_time'];

    //黑名单
    // protected $guarded = array('fid');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    protected $appends = array('group_names');


    //static $status_map =array();

    public function getGroupNamesAttribute()
    {

        $group_names = '';
        if (!empty($this->relations['groups'])) {
            foreach ($this->relations['groups'] as $v) {
                $group_names .=($group_names==''?'':','). $v->group_name;
            }
        }
        return $group_names;
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\AdminGroup', 'admin_user_group', 'uid', 'gid');
    }

}
