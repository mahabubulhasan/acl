<?php

namespace Uzzal\Acl\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uzzal\Acl\Services\ResourceService;
use Uzzal\Acl\Models\Resource;

class ResourceController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('acl::resource.index', [
            'rows' => Resource::paginate(30)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('acl::resource.create');
    }

    /**
     * @param ResourceService $resourceService
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        return view('acl::resource.edit', [
            'id' => $id,
            'resource' => Resource::find($id)
                ]
        );
    }

    /**
     * @param $id
     * @param ResourceService $resourceService
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        if (Resource::destroy($id)) {
            return redirect('/resource')->with('msg', 'Resource deleted successfully!');
        }

        return redirect('/resource')->with('msg', 'Resource can\'t deleted successfully!');
    }

}
