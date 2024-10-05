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

    /**
     * Get order count for a specific user
     *
     * @param int $userId
     * @return int
     */
    public function getOrderCount(int $userId): int
    {
        return $this->user->withCount('orders')->find($userId)->orders_count;
    }

    public function getProductCount(int $userId): int
    {
        return $this->user->find($userId)->products()->count();
    }

    public function getUserByAuthorId(int $author_id): User
    {
        return $this->user->find($author_id)->first();
    }
}
