<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreatePermissionAPIRequest;
use App\Http\Requests\API\Admin\UpdatePermissionAPIRequest;
use App\Models\Admin\Permission;
use App\Repositories\Admin\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Response;
use Exception;
use Log;

/**
 * Class PermissionController
 * @package App\Http\Controllers\API\Admin
 */

class PermissionAPIController extends AppBaseController
{
    private static $limit = 10;

    /** @var  PermissionRepository */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepo)
    {
        //$this->middleware('api');
        //$this->middleware(['permission:crear-permissions|leer-permissions|actualizar-permissions|borrar-permissions']);
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Permission.
     * GET|HEAD /permissions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $permissions = Permission::withTrashed();

        if (!is_null($term)) {
            $permissions = $permissions->where('name', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%");
        }

        $permissions = $permissions->paginate(self::$limit);

        return $this->sendResponse($permissions->toArray(), 'Permissions retrieved successfully');
    }

    public function all(Request $request)
    {
        $roles = Permission::whereNotNull('created_at')->get();

        return $this->sendResponse($roles->toArray(), 'Permissions retrieved successfully');
    }

    /**
     * Store a newly created Permission in storage.
     * POST /permissions
     *
     * @param CreatePermissionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissionAPIRequest $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Permission::$rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $permission = $this->permissionRepository->create($input);

        return $this->sendResponse($permission->toArray(), 'Permission saved successfully');
    }

    public function stores(Request $request)
    {
        try {
            $input = $request->all();
            DB::beginTransaction();

            foreach ($input as $permission) {

                $rules = [
                    'display_name' => 'required|unique:permissions,display_name,'
                ];

                $validator = Validator::make($permission, $rules);

                if ($validator->fails()) {
                    DB::rollBack();
                    return $this->sendError($validator->errors()->first());
                }

                $this->permissionRepository->create($permission);
            }
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('stores', ['message' => $th->getMessage()]);
            return $this->sendError($th->getMessage());

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('stores', ['message' => $th->getMessage()]);
            return $this->sendError($th->getMessage());
        }

        return $this->sendResponse([], 'Permissions saved successfully');
    }

    /**
     * Display the specified Permission.
     * GET|HEAD /permissions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        return $this->sendResponse($permission->toArray(), 'Permission retrieved successfully');
    }

    /**
     * Update the specified Permission in storage.
     * PUT/PATCH /permissions/{id}
     *
     * @param int $id
     * @param UpdatePermissionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermissionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        $permission = $this->permissionRepository->update($input, $id);

        return $this->sendResponse($permission->toArray(), 'Permission updated successfully');
    }

    /**
     * Remove the specified Permission from storage.
     * DELETE /permissions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        $permission->delete();

        return $this->sendSuccess('Permission deleted successfully');
    }

    /**
     * Restore the specified User from storage.
     * POST /permission/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function restore($id)
    {
        /** @var Permission $permission */
        $permission = Permission::withTrashed()->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        $permission->restore();

        return $this->sendResponse($permission, 'Permissions restored successfully');
    }
}
