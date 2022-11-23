<?php

namespace Modules\Users\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Users\Entities\Role;

class RolesExists implements Rule
{
    private array $missingRoles = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  array  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        collect($value)->each(function ($name, $key) {
            $role = Role::where('name', $name)->exists();

            if (!$role)
                $this->missingRoles["roles[$key]"] = "Role $name does not exists.";
        });

        return empty($this->missingRoles);
    }

    /**
     * Get the validation error message.
     *
     * @return array
     */
    public function message(): array
    {
        return [
            "roles" => $this->missingRoles
        ];
    }
}
