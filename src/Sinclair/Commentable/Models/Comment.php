<?php

namespace Sinclair\Commentable\Models;

use Exception;
use Sinclair\Commentable\Contracts\Comment as CommentInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements CommentInterface
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'text', 'user_id', 'resolution' ];

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
        return $this->belongsTo(config('commentable.user.class'));
    }

    public function __call( $name, $arguments )
    {
        try
        {
            if ( in_array($name, array_keys($this->getAttributes())) )
                return parent::__call($name, $arguments);

            if ( method_exists($this, $name) )
                return call_user_func_array($name, $arguments);

            $model = app(studly_case(str_singular($name)));

            $model = new \ReflectionClass($model);

            return $this->morphedByMany($model->getName(), 'commentable');
        }
        catch ( Exception $e )
        {
            return parent::__call($name, $arguments);
        }
    }

    public static function __callStatic( $name, $arguments )
    {
        return self::__call($name, $arguments);
    }

    public function __get( $name )
    {
        try
        {
            if ( in_array($name, array_keys($this->getAttributes())) )
                return parent::__get($name);

            if ( method_exists($this, $name) )
                return call_user_func($name);

            $model = app(studly_case(str_singular($name)));

            $model = new \ReflectionClass($model);

            return $this->relations[ $name ] = $this->morphedByMany($model->getName(), 'commentable')
                                                    ->getResults();
        }
        catch ( Exception $e )
        {
            return parent::__get($name);
        }
    }
}
