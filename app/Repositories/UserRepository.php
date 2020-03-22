<?php

namespace App\Repositories;

use App\Models\User;

/**
 * usersに対してのデータ永続化に関するクラス
 *
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * 指定したIDのユーザを取得
     *
     * @param string $id
     * @return User|null
     */
    public function find(string $id): ?User
    {
        return User::where('id', $id)->first();
    }
}
