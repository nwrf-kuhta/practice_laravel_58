<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Repositories\UserRepository;

class UserService
{
    /** @var UserRepository ユーザリポジトリ */
    private $user_repository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $user_repository
     */
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * ID指定でユーザとrole_idに紐づくロールを取得
     *
     * @param int $id
     * @return User
     */
    public function findWithRole(int $id): User
    {
        // RepositoryからUserモデルを取得
        $user = $this->user_repository->findWithRole($id);

        // 取得できなかった場合は、インスタンスを生成して返す
        if (is_null($user)) {
            $user = new User();
            $user->role = new Role();
        }

        return $user;
    }
}
