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

    public function getWelcomeMessage()
    {
        return 'Welcome to Laravel 12 Roch PHP Core';
    }

    public function listUsers($search = null, $status = null, $fromDate = null, $toDate = null)
    {
        return $this->repo->all($search, $status, $fromDate, $toDate);
    }

    public function listAllUsers($search = null, $status = null, $fromDate = null, $toDate = null)
    {
        return $this->repo->allWithoutPagination($search, $status, $fromDate, $toDate);
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

    public function getInactiveUsersCount()
    {
        return $this->repo->getInactiveUsersCount();
    }

    public function getWeeklyUsersCount()
    {
        return $this->repo->getWeeklyUsersCount();
    }

    public function getMonthlyUsersCount()
    {
        return $this->repo->getMonthlyUsersCount();
    }

    public function getWeeklyRegistrations()
    {
        return $this->repo->getWeeklyRegistrations();
    }

    public function getMonthlyRegistrations()
    {
        return $this->repo->getMonthlyRegistrations();
    }

    public function getUserGrowthData()
    {
        return $this->repo->getUserGrowthData();
    }
}
