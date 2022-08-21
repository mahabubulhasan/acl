# acl

> Upgraded to support Laravel 8 and latest versions

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
This command will publish view files inside `views/vendor/acl`, 
seed files inside the `databases/seed` and a config file `config/acl.php`.

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

### #Attribute

Acl library now has two attribute support `#Resource`, and `#Authorize` to be used with controller action
```php
#[Authorize('Admin, Default')]
#[Resource('able to see home')]
public function index()
{
    return view('home');
}
```
NOTE: by default **developer** role has the highest permission level, and it doesn't need to be mentioned in the 
`#Authorize` attribute. If you remove the `#Authorize` attribute it won't delete the permissions from the 
database, but if you change the role list in the annotation then it will update the databased accordingly.

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

### Role &amp; Resource UI

To access role visit `YOUR-HOST/role` url

To access resource UI visit `YOUR-HOST/resource` url

### access check
There are several ways to check for access

By route name here `home.index` is the name of the route.
```php
if (Auth::user()->allowed('home.index')) {
    echo "will allow here if the user has access";
}

// alternatively in blade template

@allowed('home.index')
<h4>Will be visible if the user has permission</h4>
@endallowed
```
By controller's action name
```php
if (Auth::user()->allowed([\App\Http\Controllers\HomeController::class, 'index'])) {
    echo "will allow here if the user has access";
}

// alternatively in blade template

@allowed([\App\Http\Controllers\HomeController::class, 'index'])
<h4>Will be visible if the user has permission</h4>
@endallowed
```




