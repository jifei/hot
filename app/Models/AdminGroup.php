<?php namespace App\Models;

class AdminGroup extends BaseModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admin_group';
    protected $primaryKey = 'gid';


    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['group_name'];

    //黑名单
   // protected $guarded = array('fid');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [''];

}
