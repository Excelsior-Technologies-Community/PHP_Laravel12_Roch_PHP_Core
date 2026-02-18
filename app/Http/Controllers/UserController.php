<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->listUsers();
        return view('users.index', compact('users'));
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

        $this->service->storeUser($request->only('name','email'));
        return redirect()->route('users.index')->with('success','User Created');
    }

    public function edit($id)
    {
        $user = $this->service->getUser($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->service->updateUser($id, $request->only('name','email'));
        return redirect()->route('users.index')->with('success','User Updated');
    }

    public function destroy($id)
    {
        $this->service->deleteUser($id);
        return redirect()->route('users.index')->with('success','User Deleted');
    }
}
