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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(RoleService $service) {
        return view('acl::role.create', [
            'resources' => $service->groupResource(Resource::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, RoleService $service) {        
        $validator = $service->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $service->create($request->all());
        return redirect('/role')->with('msg', 'Role created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, RoleService $service, Request $request) {        
        $validator = $service->validator($request->all(), $id);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $service->update($id, $request->all());
        return redirect('/role')->with('msg', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Role::destroy($id);
        Permission::where('role_id', '=', $id)->delete();
        return redirect('/role')->with('msg', 'Role removed successfully!');
    }

}
