<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin\Profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Validator;
use Log;

/**
 * Class UserController
 * @package App\Http\Controllers\API\Admin
 */

class UserAPIController extends AppBaseController
{
    private static $limit = 10;

    public function __construct()
    {
        //$this->middleware('api');
        //$this->middleware(['permission:crear-usuarios|leer-usuarios|actualizar-usuarios|borrar-usuarios']);
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $users = User::withTrashed()->with('roles');

        if (!is_null($term)) {
            $users = $users->where('name', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%");
        }

        $users = $users->paginate(self::$limit);

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    public function all(Request $request)
    {
        $users = User::whereNotNull('created_at')->get();

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), User::$rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $user = User::create($input);

        if (isset($input['rolesIds']) && !empty($input['rolesIds'])) {
            $user->syncRoles($input['rolesIds']);
        }

        $user->roles;

        if (isset($input['profile']) && !empty($input['profile'])) {
            $profileInput = $input['profile'];
            $profileInput['user_id'] = $user->id;

            $validator = Validator::make($profileInput, Profile::$rules);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            Profile::create($profileInput);
        }

        return $this->sendResponse($user->toArray(), 'User saved successfully');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        $rules = [
                'name'  => 'required',
                'email' => 'required|email|unique:users,email,' . $id
            ];

        if (isset($input['password']) && !empty($input['password'])) {
            $rules['password'] = 'required|confirmed';
        } else {
            unset($input['password']);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        /** @var User $user */
        $user = User::with('roles.permissions')->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->update($input);

        if (isset($input['rolesIds']) && !empty($input['rolesIds'])) {
            $user->syncRoles($input['rolesIds']);
        }

        $user->roles;

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendSuccess('User deleted successfully');
    }

    /**
     * Restore the specified User from storage.
     * POST /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function restore($id)
    {
        /** @var User $user */
        $user = User::withTrashed()->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->restore();

        return $this->sendResponse($user, 'Users restored successfully');
    }
}
