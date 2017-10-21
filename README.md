# acl

Dynamically configurable access control for Laravel. One user can have multiple roles.

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
At your `DatabaseSeeder.php` under `database/seeds` add the following lines

```php
$this->call(UserTableSeeder::class); //optional        
$this->call(RoleTableSeeder::class);
$this->call(ResourceTableSeeder::class);
$this->call(PermissionTableSeeder::class);
$this->call(UserRoleTableSeeder::class);
```
NOTE: If you see any kind of class not found type error try running `composer dump-autoload` 

### artisan
This library comes with an artisan command `acl:resource` to automatically create all the resources (_controller@action_) available in your project under `app/Http/Controllers` directory. To activate this command you need to add these following lines to your `app/Console/Kernel.php` file. 
```php
protected $commands = [
    Uzzal\Acl\Commands\AclResource::class
];

```

### middleware
This ACL library comes with two middleware as shown below. `AuthenticateWithAcl` is the middleware you need. The other `ResourceMaker` middle ware is just a helper to create resource dynamically if it doesn't exists in the first place and assign permission for it to the `developer` role.  

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
*IMPORTANT*: `resource.maker` must have to be placed before `auth.acl`. In production you can remove `resource.maker` once you have all the resource generated.

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
