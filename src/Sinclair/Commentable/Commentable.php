<?php

namespace Sinclair\Commentable;

use Sinclair\Commentable\Models\Comment;

/**
 * Class Commentable
 * @package Sinclair\Commentable
 */
trait Commentable
{
    /**
     * Comments relationship
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeHasComments( $query )
    {
        return $query->has('comments');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeHasNoComments( $query )
    {
        return $query->has('comments', 0);
    }

    /**
     * @param $query
     * @param $user
     *
     * @return mixed
     */
    public function scopeHasCommentsByUser( $query, $user )
    {
        return $query->whereHas('comments', function ( $query ) use ( $user )
        {
            $query->where('user_id', $user->id);
        });
    }
}