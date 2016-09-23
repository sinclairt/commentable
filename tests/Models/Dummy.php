<?php

class Dummy extends \Illuminate\Database\Eloquent\Model
{
    use \Sinclair\Commentable\Commentable;

    protected $fillable = [ 'name' ];
}