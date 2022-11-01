<?php

namespace Modules\Users\Http\Controllers;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Modules\Users\Transformers\UserResource;
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
     */
    public function index(Request $request): Response
    {
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
     */
    public function store(CreateUserRequest $request): Response
    {
        $user = $this->userRepository->create($request->all());

        return $this->sendResponse(new UserResource($user), 'User created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
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
     */
    public function update(UpdateUserRequest $request, int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (empty($user))
            return $this->sendError('User not found');

        $input = $request->safe()->only(['first_name', 'middle_name', 'last_name', 'email', 'is_active']);

        $user = $this->userRepository->update($input, $id);
        return $this->sendResponse(new UserResource($user), 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (empty($user))
            return $this->sendError('User not found');

        $this->userRepository->delete($id);
        return $this->sendResponse([], 'User deleted successfully');
    }
}
