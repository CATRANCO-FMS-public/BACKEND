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
    public function __construct() {
        $this->model = new User();
    }


    public function registerAccount(UserStoreRequest $request) {
        try {
            $data = $request->all();
            
            $data['password'] = bcrypt($data['password']);
            $data['status'] = 1;
            $data['is_logged_in'] = 0;
            
            $this->model->create($data);
    
            return response()->json(["message" => "Account Successfully Created"], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }
    

    public function loginAccount(LoginRequest $request) {
        try {
            $credentials = $request->only(["email", "password"]);
    
            if (!Auth::attempt($credentials)) {
                return response()->json(["message" => "Account doesn't exist"], 404);
            }
    
            $user = $request->user();
    
            if ($user->is_logged_in) {
                return response()->json(["message" => "User is already logged in"], 200);
            }
    
            $user->update(['is_logged_in' => 1]);
    
            $token = $user->createToken("Personal Access Token")->plainTextToken;
    
            return response(['token' => $token, 'role' => $user->role_id], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
    

    public function showUser(Request $request) {
        {
            return response()->json($request->user(), 200);
        }
    }

    public function updateAccount(AccountUpdateRequest $request) {
        try {
            $user = $request->user();
            
            // Get the validated data
            $data = $request->validated();
            
            // Check if password is present in the request data
            if (isset($data['password']) && !empty($data['password'])) {
                // Hash the password
                $data['password'] = bcrypt($data['password']);
            } else {
                // If password is not set or empty, remove it from the update data
                unset($data['password']);
            }
    
            // Update the user with the validated data
            $user->update($data);
        
            return response(['message' => 'User Updated Successfully'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
    
    

    public function logoutAccount(Request $request) {
        try {
            $user = $request->user();
    
            $user->currentAccessToken()->delete();
    
            $user->update(['is_logged_in' => 0]);
    
            return response(['message' => 'Account Successfully Logged Out'], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
    
}