<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    #[OA\Post(
        path: '/api/auth/login',
        tags: ['Auth'],
        summary: 'Authenticate a user and return a JWT token',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login successful',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'code', type: 'integer', example: 200),
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', type: 'string', description: 'JWT token'),
                        new OA\Property(property: 'message', type: 'string', example: 'User Login Successfully'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Invalid credentials'),
        ]
    )]
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
