<?php
namespace Uzzal\Acl\Services;

use Uzzal\Acl\Models\Role;
use Uzzal\Acl\Models\Permission;
use Validator;
/**
 * Description of RoleService
 *
 * @author uzzal
 */
class RoleService {
    /**
     *
     * @param  array  $data
     * @param int $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, $id=0) {
        if($id){
            $action = 'required|max:30|unique:roles,name,'.$id.',role_id';
        }else{
            $action = 'required|max:30|unique:roles';
        }
        
        return Validator::make($data, [            
            'name' => $action,
        ]);
    }

    /**
     * @param $row
     * @return array
     */
    public function groupResource($row){
        $data = array();
                        
        foreach($row as $d){
            $data[$d->controller][] = array('id' => $d->resource_id, 'name' => $d->name);
        }
                
        return $data;
    }
    
    public function getPermissionArray($rows){
        if(!$rows){return array();}
        $data = array();
        foreach($rows as $r){
            $data[] = $r->resource_id;
        }
        
        return $data;
    }
    
    public function getNewAndDeletedPermissions($old, $new){
        $insert = array();
        $delete = array();
        
        foreach($old as $v){
            if(!in_array($v, $new)){
                $delete[] = $v;
            }
        }
        
        foreach($new as $v){
            if(!in_array($v, $old)){
                $insert[] = $v;
            }
        }
        
        return ['insert' => $insert, 'delete' => $delete];
    }
    
    public function create(array $data){
        $role = new Role();
        $role->name = $data['name'];
        $role->save();

        if(array_key_exists('resource', $data)){
            $this->_createPermission($role->role_id, $data['resource']);
        }
    }
    
    public function update($id, array $data){
        $resource = array();
        if(array_key_exists('resource', $data)){
            $resource = $data['resource'];
        }
        
        $old = $this->getPermissionArray(Permission::role($id)->get());        
        $permissions = $this->getNewAndDeletedPermissions($old, $resource);
        
        $role = Role::find($id);
        $role->name = $data['name'];
        $role->save();
                
        $this->_createPermission($role->role_id, $permissions['insert']);        
        $this->_removePermissions($role->role_id, $permissions['delete']);
    }
    
    private function _createPermission($id, $data){
        if(!is_array($data)){return false;}
        $row = array();        
        foreach($data as $d){
            $row[] = array('role_id'=>$id, 'resource_id' => $d);
        }
        
        Permission::bulkInsert($row);
    }
    
    private function _removePermissions($id, $data){
        Permission::where('role_id','=',$id)->whereIn('resource_id',$data)->delete();
    }
}
