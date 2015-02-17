<?php namespace App\Models;

class AdminUser extends BaseModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admin_user';
    protected $primaryKey = 'uid';


    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','real_name', 'avatar', 'mobile','email','status','password','delete_time'];

    //黑名单
   // protected $guarded = array('fid');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];

    static $status_map =array();

}
