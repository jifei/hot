<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comment';
    protected $primaryKey = 'id';


    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['uid','reply_uid','fid', 'content', 'status'];

    //黑名单
   // protected $guarded = array('fid');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


}
