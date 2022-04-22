<?php

namespace Uzzal\Acl\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uzzal\Acl\Models\Resource;
use Uzzal\Acl\Models\Role;
use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Services\RoleService;

class RoleController extends Controller {

    public function index() {                                
        return view('acl::role.index', [
            'rows' => Role::paginate(30)            
        ]);
    }

    public function create(RoleService $service) {
        return view('acl::role.create', [
            'resources' => $service->groupResource(Resource::all())
        ]);
    }

    public function store(Request $request, RoleService $service) {        
        $service->validator($request->all())->validate();
        $service->create($request->all());
        return redirect('/role')->with('msg', 'Role created successfully!');
    }

    public function edit($id, RoleService $service) {        
        return view('acl::role.edit', [
            'id' => $id,
            'role' => Role::find($id),
            'resources' => $service->groupResource(Resource::all()),
            'permissions' => $service->getPermissionArray(Permission::role($id)->get())
        ]);
    }

    public function update($id, RoleService $service, Request $request) {        
        $service->validator($request->all(), $id)->validate();
        $service->update($id, $request->all());
        return redirect('/role')->with('msg', 'Role updated successfully!');
    }

    public function destroy($id) {
        if($id==1){
            return redirect('/role')->with('msg', 'Sorry! developer role is not removable.');
        }
        Role::destroy($id);
        Permission::where('role_id', '=', $id)->delete();
        return redirect('/role')->with('msg', 'Role removed successfully!');
    }

}
