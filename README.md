# README #

### Ingredients ###
* Commentable Trait
* Comment Model
* Comments Table migration
* Comentables Table migration
* Commentable Service Provider

### Instructions ###

``` composer require sterling/commentable ```

Add ``` Sterling\Commentable\CommentableServiceProvider ``` to ``` app\config ```

``` php artisan vendor:publish ``` 

Run the migrations ``` php artisan migrate ```

### Usage ###
Use the trait ``` use Commentable; ``` in your model.

Add some logic to save comments against your model i.e. 
``` php
$machine = Machine::save(['name' => 'Machine 1']);

$machine->comments()->save(new Comment(['text' => Input::get('comment'), 'user_id' => Auth::id()]));
```

### Considerations ###

The Comment model requires the user id and has a user relationship which get its reference from the ``` auth.model ``` config value. The model is published so can be edited if needs be.

The trait has consideration for the ``` CascadeSoftDeletes ``` Trait, and adds ``` comments ``` to the ``` $children ``` array.