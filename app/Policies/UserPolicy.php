<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    // 更新用户的个人信息必须是当前用户
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
    // 删除用户必须是管理员且当前用户不是要删除的用户（即管理员不能自己删除自己）
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
