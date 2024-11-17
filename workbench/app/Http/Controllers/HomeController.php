<?php

namespace Workbench\App\Http\Controllers;
use Uzzal\Acl\Attributes\Authorize;
use Uzzal\Acl\Attributes\Resource;

class HomeController
{
    #[Authorize('Admin, Basic')]
    #[Resource('Can see homepage.')]
    public function index()
    {
        return 'home.index';
    }

    #[Authorize('Admin')]
    public function create()
    {
        return 'home.create';
    }

    #[Authorize('Admin')]
    public function store()
    {
        return 'home.store';
    }

    #[Authorize('Admin', 'Basic')]
    #[Resource('Can see show page.')]
    public function show()
    {
        return 'home.show';
    }

    #[Authorize('Admin')]
    public function edit()
    {
        return 'home.edit';
    }

    #[Authorize('Admin')]
    public function update()
    {
        return 'home.update';
    }

    #[Authorize]
    public function destroy()
    {
        return 'home.destroy';
    }
}
