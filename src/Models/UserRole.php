<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRole extends Model {

    public $timestamps = false;

    protected $table = 'user_roles';

    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['user_id', 'role_id'];

    public static function bulkInsert($data) {
        DB::table('user_roles')->insert($data);
    }
    
    public function role(){
        return $this->hasOne(Role::class,'role_id', 'role_id');
    }
}
