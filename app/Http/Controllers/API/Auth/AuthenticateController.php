<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Enums\UserRole;
use App\Models\User;
use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private CustomerRepository $customerRepository,
    ){}

    //TODO return user response
    public function login(LoginUserRequest $request) {
        $request->validated();

        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->userRepository->findByEmail($email);

        if (Hash::check($password, $user->password)) {
            return new UserResource($user);
        }

        return response()->json([
            'message' => 'Password is wrong, Invalid credentials',
            'errors' => [
                'password' => 'The provided credentials are incorrect.',

            ]
        ])->setStatusCode(422);
    }

    public function register(RegisterUserRequest $request) {

         $request->validated();

        $username = $request->input('username');
        $email = $request->input('email');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $gender = $request->input('gender');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');


        $user = User::create([
            'username' => $username,
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'gender' => $gender,
            'image_path' => $this->getImagePath($username),
            'password' => Hash::make($password),
        ]);

        $customer = $this->customerRepository->create([
            'user_id' => $user->id,
        ]);


        return response()->json([
            'message' => 'User registered successfully',
        ], 201);
    }

    public function revoke(Request $request) {
        if(!$this->userRepository->isExists($request->input('user_id'))){
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'user_id' => 'The user does not exist.',
                ]
            ]);
        }
        $user = $this->userRepository->getById($request->input('user_id'));
        $user->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Token revoked'
        ]);
    }

    protected function getImagePath(string $username): string|null
    {
        // โฟลเดอร์ที่เก็บรูปภาพ
        $defaultImagePath = 'users/default-user-profile.png';

        // ดึงรายชื่อไฟล์ทั้งหมดในโฟลเดอร์
        // คืนค่า path ของภาพที่เลือก
        return Storage::disk('public')->exists($defaultImagePath) ? $defaultImagePath : 'users/default-user-profile.png';
    }
}
