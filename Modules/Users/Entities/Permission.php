<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends \Spatie\Permission\Models\Permission
{
 use SoftDeletes;
}
