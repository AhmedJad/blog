<?php

namespace App\Repositories\Auth;

use App\Models\User;

class ProfileRepository
{
    public function updateProfile($id, $userInput)
    {
        $user = User::find($id);
        $image = $user->getImageName();
        $userInput["image"] = $userInput["image"] ?? $image;
        $user->update($userInput);
        return ["old_image" => $image, "user" => $user];
    }
}
