<?php

namespace Modules\Users\Observers;

use Modules\Users\Entities\User;

class UserObserver
{
    /**
     * @param User $user
     * @return void
     */
    public function creating(User $user): void
    {
        $sanitizedFirstname = strtolower($user->first_name);
        $sanitizedLastname = strtolower($user->last_name);
        $user->user_id = $user->generateID();
        $user->password = bcrypt($user->password);
        $user->username = "$sanitizedFirstname.$sanitizedLastname";
        $user->is_active = true;
        $user->should_update_password = true;
    }
}
