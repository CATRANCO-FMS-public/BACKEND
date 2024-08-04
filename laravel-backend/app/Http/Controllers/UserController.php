<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateStoreRequest;
use App\Http\Requests\AuthRequest\AccountUpdateRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new user and associated profile.
     *
     * @param  \App\Http\Requests\UserCreateStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(UserCreateStoreRequest $request) {
        try {
            // Begin a transaction
            DB::beginTransaction();

            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $data['status'] = 1;
            $data['is_logged_in'] = 0;

            // Get the position from the user profile
            $userProfile = UserProfile::findOrFail($data['user_profile_id']);
            $position = $userProfile->position;

            // Map position to role_id
            $roleId = $this->mapPositionToRoleId($position);
            $data['role_id'] = $roleId;

            // Create the user
            $user = User::create($data);

            // Update the user profile with the newly created user's ID
            $userProfile->user_id = $user->user_id;
            $userProfile->save();

            // Commit the transaction
            DB::commit();

            return response()->json(["message" => "User Successfully Created", "user" => $user, "profile" => $userProfile], 200);
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Map position to role_id.
     *
     * @param  string  $position
     * @return int
     */
    private function mapPositionToRoleId($position)
    {
        $roles = [
            'Admin' => 1,
            'Dispatcher' => 2,
            'Driver' => 3,
            'Conductor' => 4,
        ];

        return $roles[$position] ?? 0; // Default to 0 if position is not found
    }

    public function getAllUsers() {
        $users = User::all();
        return response()->json($users);
    }

    public function getUserById($id) {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 404);
        }
    }

    public function updateUser(AccountUpdateRequest $request, $id) {
        try {
            $user = User::findOrFail($id);

            $data = $request->validated();

            // Hash the password if provided
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                // Remove the password field if it's not being updated
                unset($data['password']);
            }

            $user->update($data);

            return response()->json(["message" => "User Updated Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function deleteUser($id) {
        try {
            $admin = auth()->user(); // Get the current admin user
            $userToDelete = User::findOrFail($id);

            // Check if the user to be deleted is an admin
            if ($userToDelete->role_id === 1) {
                return response()->json(["message" => "Cannot delete another admin user"], 403);
            }

            // Check if the admin is trying to delete themselves
            if ($admin->user_id === $userToDelete->user_id) {
                return response()->json(["message" => "Cannot delete yourself"], 403);
            }

            $userToDelete->delete();

            return response()->json(["message" => "User Deleted Successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
}
