<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /** @var string 閲覧・編集の両方を必要とするケース */
    private const PARAMETER_BOTH = 'both';
    /** @var string 閲覧・編集のどちらかがあれば良いケース */
    private const PARAMETER_EITHER = 'either';
    /** @var string 閲覧権限があれば良いケース */
    private const PARAMETER_BROWSE = 'browse';
    /** @var string 編集権限があれば良いケース */
    private const PARAMETER_EDIT = 'edit';

    /** @var UserRepository Userに関するリポジトリ */
    private $user_repository;

    /**
     * CheckPermission constructor.
     *
     * @param UserRepository $user_repository
     */
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $parameter ミドルウェアパラメータ
     * @return mixed
     */
    public function handle($request, Closure $next, string $parameter)
    {
        // Authからログイン中のUserを取得
        $auth_user = Auth::user();
        if (is_null($auth_user)) {
            return response()->json([
                'Status'  => false,
                'Message' => 'ログインしていません。',
            ]);
        }

        // UserServiceからログイン中のユーザ情報と、紐づくロール情報を取得
        $service = new UserService($this->user_repository);
        $user    = $service->findWithRole($auth_user->id);

        // アクセス許可判定
        if (!$this->isAccessible($user, $parameter)) {
            return response()->json([
                'Status'  => false,
                'Message' => 'アクセスを許可できません。',
            ]);
        }

        // 次のミドルウェア(またはコントローラ)の処理へ
        return $next($request);
    }

    /**
     * アクセス許可判定
     *
     * @param  User $user
     * @param  string $parameter
     * @return bool
     */
    private function isAccessible(User $user, string $parameter): bool
    {
        // 権限情報を持つロールモデルを取り出す
        /** @var \App\Models\Role $role */
        $role = $user->role;

        // ミドルウェアパラメータによって権限チェック
        switch ($parameter) {
            case self::PARAMETER_BOTH:
                return ($role->isViewable() && $role->isEditable());
            case self::PARAMETER_EITHER:
                return ($role->isViewable() || $role->isEditable());
            case self::PARAMETER_BROWSE:
                return $role->isViewable();
            case self::PARAMETER_EDIT:
                return $role->isEditable();
            default:
        }

        return false;
    }
}
