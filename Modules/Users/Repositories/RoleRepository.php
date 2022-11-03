<?php

namespace Modules\Users\Repositories;

use Modules\Users\Entities\Role;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [];

    /**
     * @inheritDoc
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * @inheritDoc
     */
    public function model(): string
    {
        return Role::class;
    }

    /**
     * @param $input
     * @return Model
     */
    public function create($input): Model
    {
        $role = parent::create([
            'name' => $input['name']
        ]);

        $role->givePermissionTo($input['permissions']);

        return $role;
    }

    /**
     * @param $input
     * @param $id
     * @return Model
     */
    public function update($input, $id): Model
    {
        $role = parent::update($input, $id);

        $role->syncPermissions($input['permissions']);
        return $role;
    }
}
