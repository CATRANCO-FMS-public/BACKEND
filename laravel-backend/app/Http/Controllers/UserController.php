<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\UserStoreRequest;
use App\Http\Requests\AuthRequest\AccountUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(UserStoreRequest $request) {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $data['status'] = 1;
            $data['is_logged_in'] = 0;

            User::create($data);

            return response()->json(["message" => "User Successfully Created"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
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
