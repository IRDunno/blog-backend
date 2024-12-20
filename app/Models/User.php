<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject {
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $guarded = [
    'created_at',
    'id',
    'updated_at',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function getJWTIdentifier() {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims() {
    return [];
  }

  public function blogs() {
    return $this->hasMany(Blog::class);
  }

  // attach or detach
  public function likeBlog() {
    return $this->belongsToMany(Blog::class, "blog_likes")->withTimestamps();
  }

  // check if user liked a blog
  public function likedBlog(Blog $blog) {
    return $this->likeBlog()->where("blog_id", $blog->id)->exists();
  }

  public function getImageURL() {
    if ($this->image) {
      return url("storage/" . $this->image);
    }
    return "http://127.0.0.1:8000/storage/profile/default_profile.png";
  }
}
