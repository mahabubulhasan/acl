<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Uzzal\Acl\Services;

use Uzzal\Acl\Models\Resource;
use Validator;

/**
 * Description of ResourceService
 *
 * @author uzzal
 */
class ResourceService {
    /**
     *
     * @param  array  $data
     * @param int $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, $id=0) {
        if($id){
            $action = 'required|max:90|unique:resources,action,'.$id.',resource_id';
        }else{
            $action = 'required|max:90|unique:resources';
        }
        
        return Validator::make($data, [
            'name' => 'required|max:60',
            'controller' => 'required|max:60',
            'action' => $action,
        ]);
    }
    
    /**
     * 
     * @param array $data
     * @return Resource
     */
    public function create(array $data){
        return Resource::create([
            'resource_id'=>sha1($data['action'], false),
            'name' => $data['name'],
            'controller' => $data['controller'],
            'action' => $data['action']
        ]);
    }
    
    /**
     * 
     * @param array $data
     * @param type $id
     * @return 
     */
    public function update(array $data, $id){
        $row = Resource::find($id);
        
        $row->name = $data['name'];
        $row->controller = $data['controller'];
        $row->action = $data['action'];
        
        return $row->save();
    }
}
