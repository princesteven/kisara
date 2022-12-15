<?php

namespace Modules\Users\Entities;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Modules\Users\Traits\UserExtension;
use Illuminate\Notifications\Notifiable;
use Modules\Services\Entities\Attachment;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, UserExtension, SoftDeletes;

    protected string $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "first_name",
        "middle_name",
        "last_name",
        "user_id",
        "email",
        "is_active",
        "username",
        "password",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "password",
        "deleted_at",
    ];

    /**
     * Get all user images
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'documentable');
    }

    /**
     * Get the latest user image
     *
     * @return MorphOne
     */
    public function latestImage(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'documentable')->latestOfMany();
    }

}
