<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Enums\UserRole;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            return new UserResource($user);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ])->setStatusCode(401);
    }

    public function register(Request $request) {
//        $validator = Validator::make($request->all(), [
//            'username' => 'required|string|max:255|unique:users',
//            'email' => 'required|string|email|max:255|unique:users',
//            'firstname' => 'required|string|max:255',
//            'lastname' => 'required|string|max:255',
//            'gender' => 'required|string|in:MALE,FEMALE',
//            'password' => 'required|string|min:8|confirmed',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'message' => $validator->errors(),
//            ], 422);
//        }

        $username = $request->input('username');
        $email = $request->input('email');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $gender = $request->input('gender');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $user = $this->userRepository->findByEmail($email);
        if($user) {
            return response()->json([
                "message" => "this email is already registered",
            ], 409   );
        }

        if($password != $confirm_password) {
            return response()->json([
                'message' => 'Passwords do not match',
            ], 200);
        }


        $user = User::create([
            'username' => $username,
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'gender' => $gender,
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
