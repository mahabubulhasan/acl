<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'role_id';

    protected $fillable = ['name'];
}
