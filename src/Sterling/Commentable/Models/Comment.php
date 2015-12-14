<?php

namespace App\Models;

use App\Contracts\Comment as CommentInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sterling\Track\TrackTrait;

class Comment extends Model implements CommentInterface
{
    use SoftDeletes, TrackTrait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'text', 'user_id' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

    /**
     * The dates that are returned as Carbon objects
     *
     * @var array
     */
    protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(config('auth.model'));
    }
}
