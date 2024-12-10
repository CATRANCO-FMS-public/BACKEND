<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest\UserProfileRequest;
use App\Http\Requests\ProfileRequest\Admin\UpdateOwnProfile;
use App\Http\Requests\ProfileRequest\Dispatcher\UpdateProfileImage;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    // Admin view all profiles
    public function getAllProfiles()
    {
        $admin = Auth::user(); // Get the logged-in user

        // Get role IDs dynamically using mapPositionToRoleId
        $dispatcherRoleId = $this->mapPositionToRoleId('dispatcher');
        $driverRoleId = $this->mapPositionToRoleId('driver');
        $passengerAssistantRoleId = $this->mapPositionToRoleId('passenger_assistant_officer');
        
        $profilesQuery = UserProfile::with('user');

        // Check if the logged-in user is an operation manager
        if ($admin && $this->mapPositionToRoleId($admin->profile->position) === $this->mapPositionToRoleId('operation_manager')) {
            // Exclude the logged-in admin from the query
            $profilesQuery->whereHas('user', function ($query) use ($admin) {
                $query->where('user_id', '<>', $admin->user_id);
            });
        }

        // Filter profiles dynamically by roles for driver, passenger assistant officer, and dispatcher
        $profilesQuery->whereHas('user', function ($query) use ($dispatcherRoleId, $driverRoleId, $passengerAssistantRoleId) {
            $query->whereIn('role_id', [$dispatcherRoleId, $driverRoleId, $passengerAssistantRoleId]);
        });

        // Fetch and map the profiles
        $profiles = $profilesQuery->get()->map(function ($profile) {
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
                    'date_hired',
                    'status',
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

            // Prepare profile data with defaults
            $profileData = $request->validated();
            $profileData['date_hired'] = now()->toDateString(); // Set date_hired to today's date
            $profileData['status'] = 'off_duty'; // Set default status

            // Create the profile
            $profile = UserProfile::create($profileData);

            // Map position to role ID
            $roleId = $this->mapPositionToRoleId($profile->position);

            // Create a unique username and password based on last name and date hired
            $dateHiredFormatted = now()->format('Ymd'); // Format date_hired as Ymd
            $username = $profile->last_name . '_' . $dateHiredFormatted;
            $password = bcrypt($username);

            // Create the user account and associate it with the profile
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
                'date_hired',
                'status',
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
                    'date_hired' => 'N/A',
                    'status' => 'N/A',
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
                'date_hired',
                'status',
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

        try {
            $data = $request->validated();

            // Handle user profile image upload if present
            if ($request->hasFile('user_profile_image')) {
                // Store the uploaded image in the public storage
                $imagePath = $request->file('user_profile_image')->store('user_profiles', 'public');
                $data['user_profile_image'] = $imagePath;

                // Optionally, delete the old image if it exists
                if ($profile->user_profile_image) {
                    Storage::disk('public')->delete($profile->user_profile_image);
                }
            }

            // Update the profile with the validated data
            $profile->update($data);

            return response()->json([
                "message" => "User Profile Updated Successfully",
                "profile" => $profile,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update profile",
                "error" => $e->getMessage(),
            ], 400);
        }
    }

    // Update the logged-in user's profile
    public function updateProfileImage(UpdateProfileImage $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return response()->json(["message" => "Profile not found"], 404);
        }

        try {
            $data = $request->validated();

            // Handle user profile image upload if present
            if ($request->hasFile('user_profile_image')) {
                // Store the uploaded image in the public storage
                $imagePath = $request->file('user_profile_image')->store('user_profiles', 'public');
                $data['user_profile_image'] = $imagePath;

                // Optionally, delete the old image if it exists
                if ($profile->user_profile_image) {
                    Storage::disk('public')->delete($profile->user_profile_image);
                }
            }

            // Update the profile with the validated data
            $profile->update($data);

            return response()->json([
                "message" => "User Profile Updated Successfully",
                "profile" => $profile,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update profile",
                "error" => $e->getMessage(),
            ], 400);
        }
    }

    public function deleteUserProfileImage($id)
    {
        try {
            // Fetch the user profile by ID
            $profile = UserProfile::findOrFail($id);

            // Check if the profile has an associated image
            if ($profile->user_profile_image) {
                // Delete the image from storage
                Storage::disk('public')->delete($profile->user_profile_image);

                // Set the profile image field to null
                $profile->update(['user_profile_image' => null]);

                return response()->json([
                    "message" => "User profile image deleted successfully.",
                    "profile" => $profile,
                ], 200);
            } else {
                return response()->json(["message" => "No profile image to delete."], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to delete profile image",
                "error" => $e->getMessage(),
            ], 400);
        }
    }

    // Get all drivers
    public function getDriver()
    {
        $drivers = UserProfile::with('user')
            ->where('position', 'driver') // Filter by position
            ->get()
            ->map(function ($profile) {
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
                        'date_hired',
                        'status',
                    ]),
                ];
            });

        return response()->json($drivers, 200);
    }

    // Get all Passenger Assistant Officers
    public function getPSO()
    {
        $passengerAssistantOfficers = UserProfile::with('user')
            ->where('position', 'passenger_assistant_officer') // Filter by position
            ->get()
            ->map(function ($profile) {
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
                        'date_hired',
                        'status',
                    ]),
                ];
            });

        return response()->json($passengerAssistantOfficers, 200);
    }

}
