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
        $users = $this->userRepository->get(10);
        $total = $this->userRepository->count();

        return response()->json([
            'data' => new UserCollection($users),
            'total' => $total,
        ]);
    }


    public function show(User $user)
    {
        return new UserResource($user);
    }

}
