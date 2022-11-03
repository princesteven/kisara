<?php

namespace Modules\Users\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Users\Entities\Role;
use App\Http\Controllers\AppBaseController;
use Modules\Users\Transformers\RoleResource;
use Modules\Users\Repositories\RoleRepository;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     */
    public function index(Request $request): Response
    {
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
     */
    public function store(CreateRoleRequest $request): Response
    {
        $role = $this->roleRepository->create($request->all());

        return $this->sendResponse(new RoleResource($role), 'Role successfully created');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            $role = Role::findById($id);
            return $this->sendResponse(new RoleResource($role), 'Role successfully retrieved');
        } catch (Exception) {
            return $this->sendError('Role not found');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRoleRequest $request, int $id): Response
    {
        try {
            $role = Role::findById($id);

            $role = $this->roleRepository->update($request->all(), $role->id);

            return $this->sendResponse(new RoleResource($role), 'Role updated successfully');
        } catch (Exception) {
            return $this->sendError('Role not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            $role = Role::findById($id);

            $role->delete();

            return $this->sendResponse(null, 'Role successfully deleted');
        } catch (Exception) {
            return $this->sendError('Role not found');
        }
    }
}
