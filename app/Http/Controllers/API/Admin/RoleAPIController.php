<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateRoleAPIRequest;
use App\Http\Requests\API\Admin\UpdateRoleAPIRequest;
use App\Models\Admin\Role;
use App\Repositories\Admin\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;
use Response;
use Log;

/**
 * Class RoleController
 * @package App\Http\Controllers\API\Admin
 */

class RoleAPIController extends AppBaseController
{
    private static $limit = 10;

    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     * GET|HEAD /roles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $roles = Role::withTrashed()->whereNotNull('created_at')->with('permissions');

        if (!is_null($term)) {
            $roles = $roles->where('name', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%");
        }

        $roles = $roles->paginate(self::$limit);

        return $this->sendResponse($roles->toArray(), 'Roles retrieved successfully');
    }

    public function all(Request $request)
    {
        $roles = Role::whereNotNull('created_at')->get();

        return $this->sendResponse($roles->toArray(), 'Roles retrieved successfully');
    }

    /**
     * Store a newly created Role in storage.
     * POST /roles
     *
     * @param CreateRoleAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $validator = Validator::make($input, Role::$rules);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $role = Role::create($input);

            if (isset($input['permissionsIds'])) {
                $role->syncPermissions($input['permissionsIds']);
            }

            $role->permissions;

            return $this->sendResponse($role->toArray(), 'Role saved successfully');

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Display the specified Role.
     * GET|HEAD /roles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Role $role */
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        return $this->sendResponse($role->toArray(), 'Role retrieved successfully');
    }

    /**
     * Update the specified Role in storage.
     * PUT/PATCH /roles/{id}
     *
     * @param int $id
     * @param UpdateRoleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        $rules = [
            'display_name' => 'required|unique:roles,display_name,' . $id
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        /** @var Role $role */
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role = $this->roleRepository->update($input, $id);

        if (isset($input['permissionsIds'])) {
            Log::debug('permissionsIds', $input['permissionsIds']);
            $role->syncPermissions($input['permissionsIds']);
            if (empty($input['permissionsIds'])) {
                $role->permissions()->delete();
            }
        }

        $role->permissions;

        return $this->sendResponse($role->toArray(), 'Role updated successfully');
    }

    /**
     * Remove the specified Role from storage.
     * DELETE /roles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Role $role */
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role->delete();

        return $this->sendSuccess('Role deleted successfully');
    }

    /**
     * Restore the specified Role from storage.
     * POST /roles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function restore($id)
    {
        /** @var Role $role */
        $role = Role::withTrashed()->find($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role->restore();

        return $this->sendResponse($role, 'Roles restored successfully');
    }
}
