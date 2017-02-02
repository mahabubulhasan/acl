<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
    
    /**
     *
     * @var integer
     */
    protected $primaryKey = 'role_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
