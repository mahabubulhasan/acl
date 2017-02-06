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
