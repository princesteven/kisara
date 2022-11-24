<?php

namespace Modules\Users\Http\Controllers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserResource;
use Illuminate\Http\Client\RequestException;
use Modules\Users\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Modules\Users\Http\Requests\CreateUserRequest;
use Modules\Users\Http\Requests\UpdateUserRequest;

class UsersController extends AppBaseController
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a list of all users.
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('view', User::class);

        $users = $this->userRepository->all(
            Arr::except($request->all(), ['limit', 'skip']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(UserResource::collection($users), 'Users list');
    }

    /**
     * Store a newly created user.
     * @param CreateUserRequest $request
     * @return Response
     * @throws RequestException
     * @throws AuthorizationException
     */
    public function store(CreateUserRequest $request): Response
    {
        $this->authorize('create', User::class);

        $user = $this->userRepository->create($request->all());

        return $this->sendResponse(new UserResource($user), 'User created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function show(int $id): Response
    {
        $this->authorize('show', User::class);

        $user = $this->userRepository->find($id);

        if (empty($user))
            return $this->sendError('User not found');

        return $this->sendResponse(new UserResource($user), 'User details');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUserRequest $request
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, int $id): Response
    {
        $this->authorize('update', User::class);

        $user = $this->userRepository->find($id);

        if (empty($user))
            return $this->sendError('User not found');

        $input = $request->safe()->only(['first_name', 'middle_name', 'last_name', 'email', 'is_active', 'roles']);

        $user = $this->userRepository->update($input, $id);
        return $this->sendResponse(new UserResource($user), 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(int $id): Response
    {
        $this->authorize('delete', User::class);

        $user = $this->userRepository->find($id);

        if (empty($user))
            return $this->sendError('User not found');

        $this->userRepository->delete($id);
        return $this->sendResponse([], 'User deleted successfully');
    }
}
