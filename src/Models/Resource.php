<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resources';
    
    /**
     *
     * @var string
     */
    protected $primaryKey = 'resource_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['resource_id','name','controller','action'];
    
    public function permissoin(){
        return $this->hasMany('Uzzal\Acl\Models\Permission', 'resource_id', 'resource_id');
    }
}
