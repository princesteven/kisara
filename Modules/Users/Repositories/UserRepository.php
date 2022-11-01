<?php

namespace Modules\Users\Repositories;

use Modules\Users\Entities\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\RequestException;

class UserRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'username' => 'like',
        'first_name' => 'like',
        'middle_name' => 'like',
        'last_name' => 'like',
        'email' => '=',
    ];

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
        return User::class;
    }

    /**
     * @throws RequestException
     */
    public function create($input): Model
    {
        return parent::create($input);
    }

    public function update($input, $id): Model
    {
        return parent::update($input, $id);
    }
}
