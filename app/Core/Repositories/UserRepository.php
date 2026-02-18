<?php

namespace App\Core\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::latest()->get();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function update($id, array $data)
    {
        return User::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}
