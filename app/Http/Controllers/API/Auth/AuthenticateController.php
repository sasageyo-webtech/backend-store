<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Enums\UserRole;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
    ){}

    //TODO return user response
    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ])->setStatusCode(404);
        }
        if (Hash::check($password, $user->password)) {
            return response()->json([
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'image_path' => $user->image_path,
                'role' => $user->role,
                'token' => $user->createToken('token')->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ])->setStatusCode(401);
    }

    public function register(Request $request) {
        // TODO Validate User Register
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|min:8|confirmed',
//        ]);

        $username = $request->input('username');
        $email = $request->input('email');
        $phone_number = $request->input('phone_number');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $user = $this->userRepository->findByEmail($email);
        if($user) {
            return response()->json([
                "message" => "this email is already registered",
            ], 400  );
        }

        if($password != $confirm_password) {
            return response()->json([
                'message' => 'Passwords do not match',
            ], 400);
        }


        $user = User::create([
            'username' => $username,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => Hash::make($password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
        ], 201);
    }

    public function revoke(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Token revoked'
        ]);
    }
}
