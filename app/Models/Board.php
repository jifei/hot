<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'board';
    protected $primaryKey = 'bid';


    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['bid','name', 'code', 'uid','pid','aid'];

    //黑名单
   // protected $guarded = array('fid');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


}
