<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(CreateRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile("image")) {
            $validated["image"] = $request->file("image")->store("profiles", "public");
        }
        $user = User::create($validated);

        return new UserResource($user);
    }

    public function login(LoginRequest $request, User $user)
    {
        if (!$token = auth()->attempt($request->only(["email", "password"]))) {
            return response()->json([
                "errors" => [
                    "invalid" => [
                        "Invalid username or password",
                    ]
                ]
            ], 422);
        }

        return (new UserResource($request->user()))->additional([
            "meta" => [
                "token" => $token,
            ]
        ]);
    }

    public function logout() {
        auth()->logout();
    }

    public function user(Request $request) {
        return new UserResource($request->user());
    }
}
