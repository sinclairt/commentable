# Commentable #

###Installation

``` composer require sinclair/commentable ```

Add ``` Sinclair\Commentable\CommentableServiceProvider::class ``` to ``` config\app.php ```

``` php artisan vendor:publish ``` 

Run the migrations ``` php artisan migrate ```

###Usage
Set your user class in the commentable config file.

Use the trait ``` use Commentable; ``` in your model. now you can create comments against objects in your app.

*Please note that the relationship is now a polymorphic one-to-many, a comment can belong to any ONE object, and an object can have MANY comments. It is no longer many-to-many.*