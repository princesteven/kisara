<?php

namespace Modules\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Entities\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return $user->hasAnyPermission(['users:view']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['users:create']);
    }

    public function show(User $user): bool
    {
        return $user->hasAnyPermission(['user:view']);
    }

    public function update(User $user): bool
    {
        return $user->hasAnyPermission(['users:update']);
    }

    public function delete(User $user): bool
    {
        return $user->hasAnyPermission(['users:delete']);
    }
}
