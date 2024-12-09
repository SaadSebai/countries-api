<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function create(LoginRequest $request)
    {
        $user = User::whereClientId($request->client_id)->first();

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function destroy()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }
}
