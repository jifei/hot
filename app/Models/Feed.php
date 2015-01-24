<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'feed';
    protected $primaryKey = 'fid';


    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['fkey','title', 'bid', 'uid','link','domain','status'];

    //黑名单
   // protected $guarded = array('fid');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['fid','deleted_at'];


}
