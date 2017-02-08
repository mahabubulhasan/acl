<?php

namespace Uzzal\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserRole extends Model {
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
    protected $table = 'user_roles';

    /**
     *
     * @var integer
     */
    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'role_id'];

    public static function bulkInsert($data) {
        DB::table('user_roles')->insert($data);
    }
    
    public function role(){
        return $this->hasOne('Uzzal\Acl\Models\Role','role_id', 'role_id');
    }
    
}
