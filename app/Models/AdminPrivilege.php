<?php namespace App\Models;

class AdminPrivilege extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table      = 'admin_privilege';
    protected $primaryKey = 'pid';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'ppid', 'url', 'type', 'status'];

    //黑名单
    // protected $guarded = array('fid');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden  = [];
    protected $appends = array('type_name','p_title');

    public function getTypeNameAttribute()
    {
        return $this->attributes['type'] == '1' ? '菜单' : '按钮';
    }
    public function getPTitleAttribute()
    {
        return !empty($this->relations['parent'])? $this->relations['parent']->title : '';
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\AdminPrivilege','ppid');
    }

}
