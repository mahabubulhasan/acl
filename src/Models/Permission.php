<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Permission
 * @package Uzzal\Acl\Models
 * @author Mahabubul Hasan Uzzal <codehasan@gmail.com>
 */
class Permission extends Model
{

    public $timestamps = false;

    protected $table = 'permissions';

    protected $primaryKey = 'permission_id';

    protected $fillable = ['role_id', 'resource_id'];

    public static function bulkInsert($data)
    {
        DB::table('permissions')->insert($data);
    }

    public function scopeRoles($query, $roles)
    {
        return $query->whereIn('role_id', $roles);
    }

    public function scopeRole($query, $role_id)
    {
        return $query->whereRoleId($role_id);
    }

    public function scopeResource($query, $resource_id)
    {
        return $query->whereResourceId($resource_id);
    }

    public function resourceItem()
    {
        return $this->hasOne(Resource::class, 'resource_id', 'resource_id');
    }
}
