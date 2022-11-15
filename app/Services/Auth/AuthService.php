<?php

namespace App\Services\Auth;

use App\Constants\PlatformType;
use App\Mail\EmailVerification;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    private $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function register(array $registerInput): void
    {
        $this->authRepository->createUser($this->getUserInput($registerInput));
        $verificationCode = Str::random(5);
        $this->authRepository->createEmailVerification([
            "email" => $registerInput["email"],
            "verification_code" => $verificationCode,
        ]);
        Mail::to($registerInput["email"])->send(new EmailVerification($verificationCode));
    }
    //Commons
    private function getUserInput(array $registerInput): array
    {
        return [
            "first_name" => $registerInput["first_name"],
            "last_name" => $registerInput["last_name"],
            "email" => $registerInput["email"],
            "password" => $registerInput["password"],
        ];
    }
}
