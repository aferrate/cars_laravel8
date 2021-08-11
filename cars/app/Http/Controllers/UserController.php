<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\UseCases\User\GetAllUsers;
use App\Application\UseCases\User\GetCreateInfoUser;
use App\Application\UseCases\User\InsertUser;
use App\Application\UseCases\User\GetUserInfo;
use App\Application\UseCases\User\GetEditInfoUser;
use App\Application\UseCases\User\UpdateUser;
use App\Application\UseCases\User\DeleteUser;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
    
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GetAllUsers $getAllUsers)
    {
        $users = $getAllUsers->getAllUsers();
        $users = $this->paginate($users);

        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(GetCreateInfoUser $getCreateInfoUser)
    {
        $roles = $getCreateInfoUser->getAllRoleNames();

        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, InsertUser $insertUser)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $insertUser->insertUser($input);

        return redirect()->route('users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, GetUserInfo $getUserInfo)
    {
        $user = $getUserInfo->getUserInfo($id);

        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id, GetEditInfoUser $getEditInfoUser)
    {
        $result = $getEditInfoUser->getEditInfoUser($id);
        $user = $result['user'];
        $roles = $result['roles'];
        $userRole = $result['userRole'];

        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id, UpdateUser $updateUser)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $updateUser->update($request->all(), $id);

        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, DeleteUser $deleteUser)
    {
        $deleteUser->delete($id);

        return redirect()->route('users.index')->with('success','User deleted successfully');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function paginate($items, $perPage = 10, $page = null, $options = ['path' => 'users'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
