<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $users = $this->service->listUsers($search);

        $totalUsers = User::count();

        $todayUsers = User::whereDate(
            'created_at',
            today()
        )->count();

        return view(
            'users.index',
            compact(
                'users',
                'search',
                'totalUsers',
                'todayUsers'
            )
        );
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $this->service->storeUser(
            $request->only('name', 'email')
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'User Created Successfully');
    }

    public function edit($id)
    {
        $user = $this->service->getUser($id);

        return view(
            'users.edit',
            compact('user')
        );
    }

    public function update(Request $request, $id)
    {
        $this->service->updateUser(
            $id,
            $request->only('name', 'email')
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'User Updated Successfully');
    }

    public function destroy($id)
    {
        $this->service->deleteUser($id);

        return redirect()
            ->route('users.index')
            ->with('success', 'User Deleted Successfully');
    }
}