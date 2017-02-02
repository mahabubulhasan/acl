<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function scopeRole($query, $role_id) {
        return $query->whereRoleId($role_id);
    }
            
    public function scopeResource($query, $resource_id){
        return $query->whereResourceId($resource_id);
    }
    
    public function resourceItem(){
        return $this->hasOne('App\Models\User\Resource', 'resource_id', 'resource_id');
    }
}
