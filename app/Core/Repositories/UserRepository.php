<?php

namespace App\Core\Repositories;

use App\Models\User;

class UserRepository
{
    public function all($search = null)
    {
        return User::when($search, function ($query) use ($search) {

            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");

        })
            ->oldest()
            ->paginate(4);
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
        return User::findOrFail($id)->delete();
    }
}