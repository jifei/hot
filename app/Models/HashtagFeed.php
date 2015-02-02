<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class HashtagFeed extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hashtag_feed';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hashtag', 'fid', 'uid', 'display_sort','status'];

    //黑名单
    // protected $guarded = array('fid');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['fid', 'deleted_at'];

    public function feed()
    {
        return $this->belongsTo('App\Models\Feed','fid');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','uid');
    }

}
