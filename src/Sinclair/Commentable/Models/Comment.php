<?php

namespace Sinclair\Commentable\Models;

use Sinclair\Commentable\Contracts\Comment as CommentInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * @package Sinclair\Commentable\Models
 */
class Comment extends Model implements CommentInterface
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'text', 'user_id', 'commentable_type', 'commentable_id' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

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
        return $this->belongsTo(config('commentable.user.class'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo('commentable');
    }

    /**
     * @param $query
     * @param $user
     *
     * @return mixed
     */
    public function scopeByUser( $query, $user )
    {
        return $query->where('user_id', $user->id);
    }
}
