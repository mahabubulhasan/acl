<?php

namespace Uzzal\Acl\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uzzal\Acl\Models\Resource;
use Uzzal\Acl\Models\Role;
use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Services\RoleService;

class RoleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {                                
        return view('acl::role.index', [
            'rows' => Role::paginate(30)            
        ]);
    }

    /**
     * @param RoleService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleService $service) {
        return view('acl::role.create', [
            'resources' => $service->groupResource(Resource::all())
        ]);
    }

    /**
     * @param Request $request
     * @param RoleService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, RoleService $service) {        
        $service->validator($request->all())->validate();
        $service->create($request->all());
        return redirect('/role')->with('msg', 'Role created successfully!');
    }

    /**
     * @param $id
     * @param RoleService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, RoleService $service) {        
        return view('acl::role.edit', [
            'id' => $id,
            'role' => Role::find($id),
            'resources' => $service->groupResource(Resource::all()),
            'permissions' => $service->getPermissionArray(Permission::role($id)->get())
        ]);
    }

    /**
     * @param $id
     * @param RoleService $service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, RoleService $service, Request $request) {        
        $service->validator($request->all(), $id)->validate();
        $service->update($id, $request->all());
        return redirect('/role')->with('msg', 'Role updated successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        if($id==1){
            redirect('/role')->with('msg', 'Sorry! developer role is not removable.');
        }
        Role::destroy($id);
        Permission::where('role_id', '=', $id)->delete();
        return redirect('/role')->with('msg', 'Role removed successfully!');
    }

}
