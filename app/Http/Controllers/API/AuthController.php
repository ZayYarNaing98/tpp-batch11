<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if(!JWTAuth::attempt($credentials))
        {
            return $this->error("Your Email and Password is incorrect", null, 401);
        }

        $user = User::where('email', $credentials['email'])->first();

        $payload = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        $token = JWTAuth::customClaims($payload)->attempt($credentials);


        return $this->success($token, "User Login Successfully", 200);
    }
}
