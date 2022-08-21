<?php

namespace Uzzal\Acl\Services;

use Uzzal\Acl\Models\Resource;
use Illuminate\Support\Facades\Validator;

class ResourceService
{

    public function validator(array $data, $id = 0)
    {
        if ($id) {
            $action = 'required|max:90|unique:resources,action,' . $id . ',resource_id';
        } else {
            $action = 'required|max:90|unique:resources';
        }

        return Validator::make($data, [
            'name' => 'required|max:60',
            'controller' => 'required|max:60',
            'action' => $action,
        ]);
    }

    public function create(array $data)
    {
        return Resource::create([
            'resource_id' => sha1($data['action'], false),
            'name' => $data['name'],
            'controller' => $data['controller'],
            'action' => $data['action']
        ]);
    }

    public function update(array $data, $id)
    {
        return Resource::find($id)->update([
            'name' => $data['name'],
            'controller' => $data['controller'],
            'action' => $data['action']
        ]);
    }
}
