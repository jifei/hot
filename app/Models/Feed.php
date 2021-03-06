<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Feed extends Model
{

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
    protected $fillable = ['fkey', 'title',  'uid', 'link', 'domain', 'status'];

    //黑名单
    // protected $guarded = array('fid');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public function topics()
    {
        return $this->hasMany('App\Models\FeedTopic','fid');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','uid');
    }

}
