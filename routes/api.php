<?php

// use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["prefix" => "auth"], function () {
  Route::post("/register", [AuthController::class, "register"]);
  Route::post("/login", [AuthController::class, "login"]);
  Route::post("/logout", [AuthController::class, "logout"])->middleware(["auth:api"]);
  Route::get("/user", [AuthController::class, "user"]);
});

Route::group(["prefix" => "blogs"], function () {
  Route::post("/", [BlogController::class, "store"])->middleware(["auth:api"]);
  Route::get("/", [BlogController::class, "index"]);
  Route::get("/{blog}", [BlogController::class, "show"]);
  Route::patch("/{blog}", [BlogController::class, "update"])->middleware(["auth:api"]);
  Route::delete("/{blog}", [BlogController::class, "destroy"])->middleware(["auth:api"]);

  // Like and Unlike
  Route::post("/{blog}/like", [BlogController::class, "like"])->middleware(["auth:api"]);
  Route::delete("/{blog}/unlike", [BlogController::class, "unlike"])->middleware(["auth:api"]);
});