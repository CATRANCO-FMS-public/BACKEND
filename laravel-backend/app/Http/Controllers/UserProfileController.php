<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest\UserProfileRequest;
use App\Http\Requests\ProfileRequest\UpdateOwnProfile;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    // Admin create profile for the users
    public function getAllProfiles() {
        $profiles = UserProfile::with('user')->get();

        $formattedProfiles = $profiles->map(function ($profile) {
            return [
                'user' => [
                    'user_id' => $profile->user->user_id ?? 'N/A',
                    'username' => $profile->user->username ?? 'N/A',
                    'email' => $profile->user->email ?? 'N/A',
                ],
                'profile' => $profile->only([
                    'user_profile_id',
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
        $profile = UserProfile::with('user')->find($id);
        
        if (!$profile) {
            return response()->json(["message" => "Profile not found"], 404);
        }

        $formattedProfile = [
            'user' => [
                'user_id' => $profile->user->user_id ?? 'N/A',
                'username' => $profile->user->username ?? 'N/A',
                'email' => $profile->user->email ?? 'N/A',
            ],
            'profile' => $profile->only([
                'user_profile_id',
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
            $profile = UserProfile::find($id);
            
            if (!$profile) {
                return response()->json(["message" => "Profile not found"], 404);
            }

            $profile->update($request->validated());
            return response()->json(["message" => "User Profile Updated Successfully", "profile" => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function deleteProfile($id) {
        try {
            $profile = UserProfile::find($id);
            
            if (!$profile) {
                return response()->json(["message" => "Profile not found"], 404);
            }

            $profile->delete();
            return response()->json(["message" => "User Profile Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Current User view and edit profile
    public function viewOwnProfile()
    {
        try {
            $user = Auth::user();
            $profile = UserProfile::where('user_id', $user->user_id)->first();

            if (!$profile) {
                return response()->json([
                    'user' => [
                        'user_id' => $user->user_id ?? 'N/A',
                        'username' => $user->username ?? 'N/A',
                        'email' => $user->email ?? 'N/A',
                    ],
                    'profile' => [
                        'user_profile_id' => 'N/A',
                        'last_name' => 'N/A',
                        'first_name' => 'N/A',
                        'middle_initial' => 'N/A',
                        'license_number' => 'N/A',
                        'address' => 'N/A',
                        'date_of_birth' => 'N/A',
                        'contact_number' => 'N/A',
                        'position' => 'N/A'
                    ]
                ], 200);
            }

            $formattedProfile = [
                'user' => [
                    'user_id' => $user->user_id ?? 'N/A',
                    'username' => $user->username ?? 'N/A',
                    'email' => $user->email ?? 'N/A',
                ],
                'profile' => $profile->only([
                    'user_profile_id',
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
            $profile = UserProfile::where('user_id', $user->user_id)->first();

            if (!$profile) {
                return response()->json(["message" => "Profile not found"], 404);
            }

            $profile->update($request->validated());
            return response()->json(["message" => "User Profile Updated Successfully", "profile" => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
