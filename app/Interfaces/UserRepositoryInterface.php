<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getAllModification();
    public function getUserById($orderId);
    public function deleteUser($orderId);
    public function createUser(array $orderDetails);
    public function updateUser($orderId, array $newDetails);
}
