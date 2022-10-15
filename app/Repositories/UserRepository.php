<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Approval\Models\Modification;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getAllModification()
    {
        return Modification::all();
    }

    public function getUserById($UserId)
    {
        return User::findOrFail($UserId);
    }

    public function deleteUser($UserId)
    {
        User::destroy($UserId);
    }

    public function createUser(array $UserDetails)
    {
        return User::create($UserDetails);
    }

    public function updateUser($UserId, array $newDetails)
    {
        return User::whereId($UserId)->update($newDetails);
    }
}
