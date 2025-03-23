<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
    ){}

    public function update(Request $request, User $user)
    {
        // ใช้ค่าจากฐานข้อมูลถ้าฟิลด์ไม่ได้ถูกส่งมา
        $firstname = $request->input('firstname', $user->firstname);
        $lastname = $request->input('lastname', $user->lastname);
        $gender = $request->input('gender', $user->gender);
        $citizen_code = $request->input('citizen_code', $user->citizen_code);
        $birthdate = $request->input('birthdate', $user->birthdate);
        $phone_number = $request->input('phone_number', $user->phone_number);

        $this->userRepository->update([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'gender' => $gender,
            'citizen_code' => $citizen_code,
            'birthdate' => $birthdate,
            'phone_number' => $phone_number,
        ], $user->id);

        return new UserResource($user->refresh());
    }

}
