<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

    protected $table = 'resources';

    protected $primaryKey = 'resource_id';
    public $incrementing = false;

    protected $fillable = ['resource_id','name','controller','action'];
    
    public function permissoin(){
        return $this->hasMany(Permission::class, 'resource_id', 'resource_id');
    }
}
