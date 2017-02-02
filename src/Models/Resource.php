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
     * @var integer
     */
    protected $primaryKey = 'resource_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','controller','action'];
}
