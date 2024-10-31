<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateInfoRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {
  public function updateInfo(UpdateInfoRequest $request, User $user) {
    $this->authorize("update", $user);
    $validated = $request->validated();
    if ($request->hasFile("image") || $request->input("default")) {
      $imagePath = null;
      if (!$request->input("default")) {
        $imagePath = $request->file("image")->store("profile", "public");
      }
      $validated["image"] = $imagePath;
      Storage::disk("public")->delete($user->image ?? "");
    }
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
