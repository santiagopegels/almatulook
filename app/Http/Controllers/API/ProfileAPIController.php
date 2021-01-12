<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Admin\CreateProfileAPIRequest;
use App\Http\Requests\API\Admin\UpdateProfileAPIRequest;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class ProfileController
 * @package App\Http\Controllers\API
 */

class ProfileAPIController extends AppBaseController
{
    /** @var  ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepo)
    {
        $this->profileRepository = $profileRepo;
    }

    /**
     * Display a listing of the Profile.
     * GET|HEAD /profiles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $profile = [];
        if(Auth::check()){
            $user = User::find(Auth::id());
            $profile = !is_null($user->profile) ? $user->profile->toArray() : null;
        }

        return $this->sendResponse($profile, 'Profiles retrieved successfully');
    }

    /**
     * Store a newly created Profile in storage.
     * POST /profiles
     *
     * @param CreateProfileAPIRequest $request
     *
     * @return Response
     */
    public function updateProfile(CreateProfileAPIRequest $request)
    {
        $profile = null;
        if(Auth::check()){
            $user = User::find(Auth::id());
            if(is_null($user->profile)){
                $input = $request->all();

                $input['user_id'] = $user->id;
                $profile = $this->profileRepository->create($input);

            }else {
                $profile = $user->profile;
                $profile->update($request->all());
            }
        }


        return $this->sendResponse($profile->toArray(), 'Actualizaste tu Perfil');
    }
}
