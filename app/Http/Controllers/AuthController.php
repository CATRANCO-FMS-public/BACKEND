<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\UserStoreRequest;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\AccountUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function registerAccount(UserStoreRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $data['status'] = 1;

            $this->model->create($data);

            return response()->json(["message" => "Account Successfully Created"], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function loginAccount(LoginRequest $request)
    {
        try {
            $credentials = $request->only(["username", "password"]);

            if (!Auth::attempt($credentials)) {
                return response()->json(["message" => "Invalid credentials"], 401);
            }

            $user = $request->user();

            if ($user->status === 0) {
                return response()->json(["message" => "Your account is deactivated. Please contact the administrator."], 403);
            }

            // Invalidate previous tokens for single-session enforcement
            $user->tokens()->delete();

            $token = $user->createToken("Personal Access Token")->plainTextToken;

            return response([
                'token' => $token,
                'user' => [
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => [
                        'role_id' => $user->role->role_id,
                        'role' => $user->role->role,
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    public function showUser(Request $request)
    {
        try {
            $user = $request->user();

            return response()->json([
                'user_id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role->role_id,
                'role' => $user->role->role,
                'status' => $user->status
            ], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    public function updateAccount(AccountUpdateRequest $request)
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            // Track if any fields were actually changed
            $changesMade = false;

            // Check if email has been changed
            if (isset($data['email']) && $data['email'] !== $user->email) {
                $changesMade = true;
            } else {
                unset($data['email']); // Do not update email if no change
            }

            // Check if password has been changed
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
                $changesMade = true;
            } else {
                unset($data['password']); // Do not update password if no change
            }

            // If no changes were made, return a "no changes" message
            if (!$changesMade) {
                return response(['message' => 'No changes were applied.'], 200);
            }

            // Update the user with the changes
            $user->update($data);

            return response(['message' => 'User Updated Successfully'], 200);

        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    public function logoutAccount(Request $request)
    {
        try {
            $user = $request->user();

            // Delete the current access token
            $user->currentAccessToken()->delete();

            return response(['message' => 'Account Successfully Logged Out'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    public function deactivateAccount($userId)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->update(['status' => 0]);

            // Invalidate tokens if the account is deactivated
            $user->tokens()->delete();

            return response()->json(['message' => 'Account successfully deactivated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function activateAccount($userId)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->update(['status' => 1]);

            return response()->json(['message' => 'Account successfully activated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
