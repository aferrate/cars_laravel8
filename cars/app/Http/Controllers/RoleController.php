<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse ;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Application\UseCases\Role\GetAllRoles;
use App\Application\UseCases\Role\GetCreateInfoRole;
use App\Application\UseCases\Role\InsertRole;
use App\Application\UseCases\Role\GetRoleInfo;
use App\Application\UseCases\Role\GetEditInfoRole;
use App\Application\UseCases\Role\UpdateRole;
use App\Application\UseCases\Role\DeleteRole;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, GetAllRoles $getAllRoles): View
    {
        $roles = $getAllRoles->getAllRoles();
        $roles = $this->paginate($roles);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(GetCreateInfoRole $getCreateInfoRole): View
    {
        $permission = $getCreateInfoRole->getPermissions();

        return view('roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, InsertRole $insertRole): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $insertRole->inserRole(['name' => $request->input('name'), 'permission' => $request->input('permission')]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(int $id, GetRoleInfo $getRoleInfo): View
    {
        $result = $getRoleInfo->getRoleInfo($id);
        $role = $result['role'];
        $rolePermissions = $result['rolePermissions'];

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id, GetEditInfoRole $getEditInfoRole): View
    {
        $result = $getEditInfoRole->getEditInfoRole($id);
        $role = $result['role'];
        $permissions = $result['permissions'];
        $rolePermissions = $result['permissionsArray'];

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id, UpdateRole $updateRole): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $updateRole->update(['name' => $request->input('name'), 'permission' => $request->input('permission')], $id);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id, DeleteRole $deleteRole): RedirectResponse
    {
        $deleteRole->delete($id);

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function paginate($items, $perPage = 10, $page = null, $options = ['path' => 'roles']): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
