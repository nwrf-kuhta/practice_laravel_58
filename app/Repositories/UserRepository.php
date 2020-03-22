<?php

namespace App\Repositories;

use App\Models\User;

/**
 * usersに対してのデータ永続化に関するクラス
 * @TODO 本当はInterfaceを作ってimplementsするのが正しいけど一旦保留
 *
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * 指定したIDのユーザを取得
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return User::where('id', $id)->first();
    }

    /**
     * 指定したIDのユーザとrole_idに紐づくロール情報を取得
     *
     * @param int $id
     * @return User|null
     */
    public function findWithRole(int $id): ?User
    {
        return User::with(['role'])
            ->where('id', $id)
            ->first();
    }
}
