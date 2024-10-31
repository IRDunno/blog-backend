<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\CreateRequest;
use App\Http\Requests\Blog\UpdateRequest;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;

class BlogController extends Controller {
  public function index() {
    $blogs = Blog::orderBy("created_at", "DESC")->paginate(3);
    return BlogResource::collection($blogs);
  }

  public function store(CreateRequest $request) {
    $validated = $request->validated();
    $validated["user_id"] = $request->user()->id;
    $blog = Blog::create($validated);
    return new BlogResource($blog);
  }

  public function update(UpdateRequest $request, Blog $blog) {
    $this->authorize("update", $blog);
    $validated = $request->validated();
    $blog->update($validated);
    return new BlogResource($blog);
  }

  public function destroy(Blog $blog) {
    $this->authorize("destroy", $blog);
    $blog->delete();
    return response()->json(["message" => "Blog deleted"]);
  }

  public function show(Blog $blog) {
    return new BlogResource($blog);
  }

  public function like(Request $request, Blog $blog) {
    $liker = $request->user();
    if (!$liker->likedBlog($blog)) {
      $liker->likeBlog()->attach($blog);
    }
    return new BlogResource($blog);
  }

  public function unlike(Request $request, Blog $blog) {
    $liker = $request->user();
    $liker->likeBlog()->detach($blog);
    return new BlogResource($blog);
  }

  public function userBlogs(User $user) {
    $blogs = $user->blogs()->paginate(3);
    return BlogResource::collection($blogs);
  }
}
