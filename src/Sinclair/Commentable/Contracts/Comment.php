<?php

namespace Sinclair\Commentable\Contracts;

/**
 * Interface Comment
 * @package Sinclair\Commentable\Contracts
 */
interface Comment
{
    /**
     * @return mixed
     */
    public function user();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable();

    /**
     * @param $query
     * @param $user
     *
     * @return mixed
     */
    public function scopeByUser( $query, $user );
}