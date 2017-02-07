# acl

Dynamically configurable access control for Laravel

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
$this->call(UserRoleTableSeeder::class);
```

NOTE: before running the seed you need to make sure you have customized this user table seeder based on your need for example we have a `is_active` column
```php
$table->boolean('is_active');
```
and also update the User model accordingly.

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
IMPORTANT: `resource.maker` must have to be placed before `auth.acl`. In production you can remove `resource.maker` once you have all the resource generated.

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

`@nullsafe()` checks for whether any of the object property is null or not in a fluent interface ($obj->prop->value), if the chain is broken it will simply return an empty string and prevent showing up `call to a member function of a non-object` exception.

Blade example: 
```php
{{ @nullsafe($obj->prop->value) }}
```
