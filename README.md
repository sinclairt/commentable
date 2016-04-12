# README #

### Ingredients ###
* Commentable Trait
* Comment Model
* Comments Table migration
* Comentables Table migration
* Commentable Service Provider
* Commentable config

### Instructions ###

``` composer require sinclair/commentable ```

Add ``` Sinclair\Commentable\CommentableServiceProvider::class ``` to ``` config\app.php ```

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

The Comment model requires the user id and has a user relationship which get its reference from the ``` commentable.user.class ``` config value, make sure you update this if your user model is not ``` App\User ```. The model can be published to be edited if needs be.

NOTE: You must update the namespace of the published model, so it does not clash with the vendor class, then add this fully qualified class to the config file.

The trait has consideration for the ``` CascadeSoftDeletes ``` Trait, and adds ``` comments ``` to the ``` $children ``` array.