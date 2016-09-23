<?php

namespace Sinclair\Commentable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Comment
 * @package Sinclair\Commentable\Facades
 */
class Comment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Comment';
    }
}