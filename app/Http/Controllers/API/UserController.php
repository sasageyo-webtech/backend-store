<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $userRepository
    ){}

    public function index()
    {
        $users = $this->userRepository->get(20);
        return new UserCollection($users);
    }


    public function show(int $user_id)
    {
        if(!$this->userRepository->isExists($user_id))
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'user_id' => 'User not found'
                ]
            ]);
        $user = $this->userRepository->getById($user_id);
        return new UserResource($user);
    }



}
