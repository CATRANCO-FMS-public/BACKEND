<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest\UserProfileRequest;
use App\Http\Requests\ProfileRequest\UpdateOwnProfile;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    // Admin view all profiles
    public function getAllProfiles()
    {
        $profiles = UserProfile::with('user')->get()->map(function ($profile) {
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
                    'sex',
                    'contact_person',
                    'contact_person_number',
                    'user_profile_image',
                    'position',
                ]),
            ];
        });

        return response()->json($profiles);
    }

    // Admin creates a profile for a user
    public function createProfile(UserProfileRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create the profile with validated data
            $profileData = $request->validated();
            $profile = UserProfile::create($profileData);

            // Map position to role ID
            $roleId = $this->mapPositionToRoleId($profile->position);

            // Create a user and link with profile
            $username = $profile->last_name;
            $password = bcrypt(($profile->last_name));

            // Create the user account and associate the profile
            $user = User::create([
                'username' => $username,
                'password' => $password,
                'status' => 1,  // active by default
                'is_logged_in' => 0,
                'role_id' => $roleId,
                'user_profile_id' => $profile->user_profile_id,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'User Profile and Account Successfully Created',
                'profile' => $profile,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    // Method to map position to role ID
    private function mapPositionToRoleId($position)
    {
        $roleMapping = [
            'operation_manager' => 1,
            'dispatcher' => 2,
            'driver' => 3,
            'passenger_assistant_officer' => 4,
        ];

        return $roleMapping[$position] ?? null;
    }

    // Get a profile by its ID
    public function getProfileById($id)
    {
        $profile = UserProfile::with('user')->find($id);

        if (!$profile) {
            return response()->json(["message" => "Profile not found"], 404);
        }

        return response()->json([
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
                'sex',
                'contact_person',
                'contact_person_number',
                'user_profile_image',
                'position',
            ]),
        ]);
    }

    // Update profile by ID
    public function updateProfile(UserProfileRequest $request, $id)
    {
        $profile = UserProfile::with('user')->find($id);

        if (!$profile) {
            return response()->json(["message" => "Profile not found"], 404);
        }

        $profile->update($request->validated());
        return response()->json(["message" => "User Profile Updated Successfully", "profile" => $profile], 200);
    }

    // Delete profile by ID
    public function deleteProfile($id)
    {
        $profile = UserProfile::with('user')->find($id);

        if (!$profile) {
            return response()->json(["message" => "Profile not found"], 404);
        }

        $profile->delete();
        return response()->json(["message" => "User Profile Deleted Successfully"], 200);
    }

    // View the logged-in user's profile
    public function viewOwnProfile()
    {
        $user = Auth::user();

        $profile = $user->profile;

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
                    'sex' => 'N/A',
                    'contact_person' => 'N/A',
                    'contact_person_number' => 'N/A',
                ]
            ]);
        }

        return response()->json([
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
                'sex',
                'contact_person',
                'contact_person_number',
                'user_profile_image',
                'position',
            ]),
        ]);
    }

    // Update the logged-in user's profile
    public function updateOwnProfile(UpdateOwnProfile $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return response()->json(["message" => "Profile not found"], 404);
        }

        $profile->update($request->validated());
        return response()->json(["message" => "User Profile Updated Successfully", "profile" => $profile], 200);
    }
}
