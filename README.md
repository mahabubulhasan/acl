# acl

Dynamically configurable access control for laravel

### install

```
composer require uzzal/acl
```

### configure
In your laravel config/app.php under providers add 

```php
Uzzal\Acl\AclServiceProvider::class
```
### publish
```
artisan vendor:publish
```

### seed
At your DatabaseSeeder add

```php
$this->call(UserTableSeeder::class);        
$this->call(RoleTableSeeder::class);
$this->call(ResourceTableSeeder::class);
$this->call(PermissionTableSeeder::class);
```

NOTE: before running the seed you need to make sure your user table has `role_id`, `is_active` columns
```php
$table->integer('role_id')->unsigned();
$table->boolean('is_active');
```
also update the User model accordingly.

### middleware
In your `kernal.php` file add this lines
```php
'auth.acl' => \Uzzal\Acl\Middleware\AuthenticateWithAcl::class,        
'resource.maker' => \Uzzal\Acl\Middleware\ResourceMaker::class,
```
In your `route/web.php` file add this lines
```php
Route::group(['middleware' => ['resource.maker','auth.acl']], function () {    
    Route::get('/home', 'HomeController@index');    
});
```
### helpers

`has_access` checks for if a role has access to a specific controller action.
```php
@if(has_access('User\UserController@getIndex'))
OR
@if(has_access('UserController@getIndex'))
```

`has_group_access` checks for if a role has access to a specific controller   
```php 
@if(has_group_access(['User-User','User-Role','User-Resource']))
OR
@if(has_group_access('User-User'))
```

`@nullsafe()` checks of if any of the object property is null or not in a fluent ($obj->prop->value) interface, if the chain break it will simply return empty string and prevent showing up `call to a member function of a non-object` exception.

Blade example: 
```php
{{@nullsafe($obj->prop->value)}}
```
