<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Permission
 * @package Uzzal\Acl\Models
 * @author Mahabubul Hasan Uzzal <codehasan@gmail.com>
 */
class Permission extends Model {
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     *
     * @var integer
     */
    protected $primaryKey = 'permission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'resource_id'];

    public static function bulkInsert($data) {
        DB::table('permissions')->insert($data);
    }

    public function scopeRoles($query, $roles){
        return $query->whereIn('role_id', $roles);
    }
            
    public function scopeResource($query, $resource_id){
        return $query->whereResourceId($resource_id);
    }
    
    public function resourceItem(){
        return $this->hasOne('Uzzal\Acl\Models\Resource', 'resource_id', 'resource_id');
    }
}
