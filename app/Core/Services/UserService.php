<?php

namespace App\Core\Services;

use App\Core\Repositories\UserRepository;

class UserService
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listUsers($search = null)
    {
        return $this->repo->all($search);
    }

    public function storeUser($data)
    {
        return $this->repo->create($data);
    }

    public function getUser($id)
    {
        return $this->repo->find($id);
    }

    public function updateUser($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->repo->delete($id);
    }
}