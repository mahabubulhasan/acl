[![StandWithPalestine](https://raw.githubusercontent.com/Safouene1/support-palestine-banner/master/StandWithPalestine.svg)](https://techforpalestine.org/learn-more)

# ACL

> Upgraded to support Laravel 8 and latest versions

Dynamically configurable access control for Laravel. One user can have multiple roles.

### Install

```
composer require uzzal/acl
```

### Configuration
In your laravel `config/app.php` under providers add

```php
Uzzal\Acl\AclServiceProvider::class
```
### Publish
```
artisan vendor:publish
```
This command will publish view files inside `views/vendor/acl`,
seed files inside the `databases/seed` and a config file `config/acl.php`.

### Database seed
At your `DatabaseSeeder.php` under `database/seeds` add the following lines

```php
$this->call(UserTableSeeder::class); //optional
$this->call(RoleTableSeeder::class);
$this->call(ResourceTableSeeder::class);
$this->call(PermissionTableSeeder::class);
$this->call(UserRoleTableSeeder::class);
```
NOTE: If you see any kind of class not found type error try running `composer dump-autoload`

### Artisan command
This library comes with an artisan command `acl:resource` to automatically create all the resources (_controller@action_) available in your project under `app/Http/Controllers` directory. To activate this command you need to add these following lines to your `app/Console/Kernel.php` file.
```php
protected $commands = [
    Uzzal\Acl\Commands\AclResource::class
];

```

### Modify the User model
In your `User` model add the following trait

```php
use Uzzal\Acl\Traits\AccessControlled;

class User extends Authenticatable
{
    use AccessControlled;
    ...
}
```

### #[Attribute]

Acl library now has two attribute support `#Resource`, and `#Authorize` to be used with controller action
```php
#[Authorize('Admin, Default')] // string
#[Resource('able to see home')]
public function index()
{
    return view('home');
}

// or alternatively

#[Authorize('Admin', 'Default')] // array
#[Resource('able to see home')]
public function index()
{
    return view('home');
}
```
> Role names are not case sensitive. But use Capitalized word for better readability.

NOTE: by default **developer** role has the highest permission level, and it doesn't need to be mentioned in the
`#Authorize` attribute. If you remove the `#Authorize` attribute it won't delete the permissions from the
database, but if you change the role list in the annotation then it will update the databased accordingly.

### Middleware
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

### Access check
There are several ways to check for access

By route name here `home.index` is the name of the route.
```php
if (allowed('home.index')) {
    echo "will allow here if the user has access";
}

// alternatively in blade template

@allowed('home.index')
<h4>Will be visible if the user has permission</h4>
@endallowed
```
By controller's action name
```php
if (allowed([\App\Http\Controllers\HomeController::class, 'index'])) {
    echo "will allow here if the user has access";
}

// alternatively in blade template

@allowed([\App\Http\Controllers\HomeController::class, 'index'])
<h4>Will be visible if the user has permission</h4>
@endallowed
```

### Checking for controller level access
Suppose you have two controllers named `HomeController` and `ProfileController` now you want to check if the user has any access to both of the controller then use the following code
```php
if (allowedAny(['Home','Profile'])) {
    echo "Will be visible if the user has permission for any action of Home and Profile controller";
}

// alternatively in blade template

@allowedAny(['Home','Profile'])
<h4>Will be visible if the user has permission for any action of Home and Profile controller</h4>
@endallowedAny

// for single controller it can be written like this

@allowedAny('Home')
<h4>Will be visible if the user has permission for any action of Home Controller</h4>
@endallowedAny
```

### Checking access by Role name
```php
if (hasRole(['Admin','Editor'])) {
    echo "Will be visible if the user has Admin or Editor or both roles";
}

// alternatively in blade template

@hasRole(['Admin','Editor'])
<h4>Will be visible if the user has Admin or Editor or both roles</h4>
@endhasRole

// for single Role it can be written like this

@hasRole('Admin')
<h4>Will be visible if the user has Admin roles</h4>
@endhasRole
```

## Contribution
```bash
composer update
vendor/bin/testbench workbench:install # not required
vendor/bin/testbench workbench:create-sqlite-db
vendor/bin/testbench migrate
vendor/bin/testbench db:seed --class=Workbench\Database\Seeders\DatabaseSeeder

vendor/bin/testbench package:test
```


