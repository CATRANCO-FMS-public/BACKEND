<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest\UserProfileRequest;
use App\Http\Requests\ProfileRequest\UpdateOwnProfile;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{

    //Admin create profile for the users
    public function getAllProfiles() {
        $profiles = UserProfile::with('user')->get();
    
        $formattedProfiles = $profiles->map(function ($profile) {
            return [
                'user' => [
                    'username' => $profile->user->username,
                    'email' => $profile->user->email,
                ],
                'profile' => $profile->only([
                    'last_name',
                    'first_name',
                    'middle_initial',
                    'license_number',
                    'address',
                    'date_of_birth',
                    'contact_number',
                    'position'
                ]),
            ];
        });
    
        return response()->json($formattedProfiles);
    }

    public function createProfile(UserProfileRequest $request) {
        try {
            $data = $request->validated();
            $profile = UserProfile::create($data);
            return response()->json(["message" => "User Profile Successfully Created", "profile" => $profile], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function getProfileById($id) {
        $profile = UserProfile::with('user')->findOrFail($id);
    
        $formattedProfile = [
            'user' => [
                'username' => $profile->user->username,
                'email' => $profile->user->email,
            ],
            'profile' => $profile->only([
                'last_name',
                'first_name',
                'middle_initial',
                'license_number',
                'address',
                'date_of_birth',
                'contact_number',
                'position'
            ]),
        ];
    
        return response()->json($formattedProfile);
    }
    

    public function updateProfile(UserProfileRequest $request, $id) {
        try {
            $profile = UserProfile::findOrFail($id);
            $profile->update($request->validated());
            return response()->json(["message" => "User Profile Updated Successfully", "profile" => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function deleteProfile($id) {
        try {
            $profile = UserProfile::findOrFail($id);
            $profile->delete();
            return response()->json(["message" => "User Profile Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }


    //Current User view and edit profile
    public function viewOwnProfile()
    {
        try {
            $user = Auth::user();
            $profile = UserProfile::where('user_id', $user->user_id)->firstOrFail();
    
            $formattedProfile = [
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email,
                ],
                'profile' => $profile->only([
                    'last_name',
                    'first_name',
                    'middle_initial',
                    'license_number',
                    'address',
                    'date_of_birth',
                    'contact_number',
                    'position'
                ]),
            ];
    
            return response()->json($formattedProfile);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function updateOwnProfile(UpdateOwnProfile $request)
    {
        try {
            $user = Auth::user();
            $profile = UserProfile::where('user_id', $user->user_id)->firstOrFail();
            $profile->update($request->validated());
            return response()->json(["message" => "User Profile Updated Successfully", "profile" => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
