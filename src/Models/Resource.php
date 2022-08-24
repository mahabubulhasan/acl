<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

    public $incrementing = false;
    protected $table = 'resources';
    protected $primaryKey = 'resource_id';
    protected $fillable = ['resource_id', 'name', 'controller', 'action'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'resource_id', 'resource_id');
    }
}
