<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateInfoRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  public function updateInfo(UpdateInfoRequest $request, User $user) {
    $this->authorize("update", $user);
    $validated = $request->validated();
    $user->update($validated);
    return new UserResource($user);
  }

  public function updatePassword(UpdatePasswordRequest $request, User $user) {
    $this->authorize("update", $user);
    $validated = $request->validated();
    $user->update($validated);
    return new UserResource($user);
  }
}
