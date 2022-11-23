<?php

namespace Modules\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Entities\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return $user->hasAnyPermission(['roles:view']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['roles:create']);
    }

    public function show(User $user): bool
    {
        return $user->hasAnyPermission(['role:view']);
    }

    public function update(User $user): bool
    {
        return $user->hasAnyPermission(['roles:update']);
    }

    public function delete(User $user): bool
    {
        return $user->hasAnyPermission(['roles:delete']);
    }
}
