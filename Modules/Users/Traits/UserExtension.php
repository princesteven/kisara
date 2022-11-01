<?php

namespace Modules\Users\Traits;

use Carbon\Carbon;
use Modules\Users\Entities\User;

trait UserExtension
{
    /**
     * Generates the user ID based on the year the user was created
     *
     * @return string
     */
    public function generateID(): string
    {
        $lastCreatedUser = User::whereYear('created_at', Carbon::now()->year)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->first();

        $carbon = Carbon::now();

        if (!$lastCreatedUser)
            return "$carbon->year-$carbon->month-001";

        return ++$lastCreatedUser->user_id;
    }
}
