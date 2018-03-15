<?php

namespace Uzzal\Acl\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uzzal\Acl\Services\ResourceService;
use Uzzal\Acl\Models\Resource;

class ResourceController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $rows = new Resource;
        if($q = request('q')){
            $rows = $rows->where('name', 'LIKE', "%{$q}%")
                        ->orWhere('controller', 'LIKE', "%{$q}%")
                        ->orWhere('action', 'LIKE', "%{$q}%");
        }

        return view('acl::resource.index', [
            'rows' => $rows->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('acl::resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ResourceService $resourceService, Request $request) {
        $validator = $resourceService->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $resourceService->create($request->all());

        return redirect('/resource')->with('msg', 'Resource created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        return view('acl::resource.edit', [
            'id' => $id,
            'resource' => Resource::find($id)
                ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, ResourceService $resourceService, Request $request) {
        $validator = $resourceService->validator($request->all(), $id);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $resourceService->update($request->all(), $id);
        return redirect('/resource')->with('msg', 'Resource updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        if (Resource::destroy($id)) {
            return redirect('/resource')->with('msg', 'Resource deleted successfully!');
        }

        return redirect('/resource')->with('msg', 'Resource can\'t deleted successfully!');
    }

}
