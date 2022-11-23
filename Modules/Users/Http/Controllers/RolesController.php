<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Users\Entities\Role;
use App\Http\Controllers\AppBaseController;
use Modules\Users\Transformers\RoleResource;
use Modules\Users\Repositories\RoleRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Users\Http\Requests\CreateRoleRequest;
use Modules\Users\Http\Requests\UpdateRoleRequest;

class RolesController extends AppBaseController
{
    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('view', Role::class);

        $roles = $this->roleRepository->all(
            Arr::except($request->all(), ['limit', 'skip']),
            $request->get('skip'),
            $request->get('limit'),
        );

        return $this->sendResponse(RoleResource::collection($roles), 'Roles list');
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateRoleRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(CreateRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $role = $this->roleRepository->create($request->all());

        return $this->sendResponse(new RoleResource($role), 'Role successfully created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function show(int $id): Response
    {
        $this->authorize('show', Role::class);

        $role = $this->roleRepository->find($id);

        if (empty($role))
            return $this->sendError('Role not found');

        return $this->sendResponse(new RoleResource($role), 'Role successfully retrieved');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return Response
     * @throws AuthorizationException
     */
    public function update(UpdateRoleRequest $request, Role $role): Response
    {
        $this->authorize('update', Role::class);

        $role = $this->roleRepository->update($request->all(), $role->id);

        return $this->sendResponse(new RoleResource($role), 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Role $role): Response
    {
        $this->authorize('delete', Role::class);

        $role->delete();

        return $this->sendResponse(null, 'Role successfully deleted');
    }
}
