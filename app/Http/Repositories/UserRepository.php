<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getById(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    public function getOrderCount(int $userId): int
    {
        return $this->user->withCount('orders')->find($userId)->orders_count;
    }

    public function getProductCount(int $userId): int
    {
        return $this->user->find($userId)->products()->count();
    }

    public function getUserByAuthorId(int $id): User
    {
        return $this->user->where('id', $id)->get();
    }
}
