<?php

namespace Sinclair\Commentable;

use Auth;
use Input;

trait Commentable
{
    /**
     * Boot Commentable Trait
     *
     */
    public static function bootCommentable()
    {
        // add comments as a child relationship to the children array so they can be soft deleted
        if ( self::usesCascadeSoftDeletes() )
            app(self::class)->addChild('comments');
    }

    /**
     * Check whether the called class uses CascadeSoftDeletes Trait
     *
     * @return bool
     */
    private static function usesCascadeSoftDeletes()
    {
        return property_exists(get_class(), 'children') && in_array('Sinclair\CascadeSoftDeletes\CascadeSoftDeletes', class_uses(self::class));
    }

    /**
     * Comments relationship
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->morphToMany(config('commentable.comment.class'), 'commentable');
    }
}