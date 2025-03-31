<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
    ){}

    public function update(UpdateUserProfileRequest $request, User $user)
    {
        if(!$this->userRepository->isExists($user->id)){
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'user' => 'User not found',
                ]
            ], 404);
        }

        $request->validated();

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

    public function updateImage(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
                'image_file' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB Limit
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity
        }

        if(!$this->userRepository->isExists($user->id)){
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'user' => 'User not found',
                ]
            ], 404);
        }

        $image_path = $user->image_path;
        $defaultImagePath = 'users/default-user-profile.png';

        //ตรวจสอบว่าเป็นภาพ default หรือไม่ หากไม่ใช่ให้ลบ
        if ($image_path && $image_path !== $defaultImagePath) {
            if (Storage::disk('public')->exists($image_path)) {
                Storage::disk('public')->delete($image_path);
            }
        }

        // If validation passes, continue with file upload logic
        $file = $request->file('image_file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $path = $file->storeAs('users', $filename, 'public');

        $this->userRepository->update([
            'image_path' => $path,
        ], $user->id);

        return new UserResource($user->refresh());
    }

    public function deleteImage(User $user)
    {
        if(!$this->userRepository->isExists($user->id)){
            return response()->json([
                'message' => 'User not found',
                'errors' => [
                    'user' => 'User not found',
                ]
            ], 404);
        }
        $user = $this->userRepository->getById($user->id);

        $image_path = $user->image_path;
        $defaultImagePath = 'users/default-user-profile.png';

        // ✅ ถ้ารูปปัจจุบันไม่ใช่ default ให้ลบ
        if ($image_path !== $defaultImagePath && Storage::disk('public')->exists($image_path)) {
            Storage::disk('public')->delete($image_path);
        }

        $this->userRepository->update([
            'image_path' => $defaultImagePath,
        ], $user->id);

        return response()->json([
            'message' => 'User image reset to default',
        ]);
    }

}
