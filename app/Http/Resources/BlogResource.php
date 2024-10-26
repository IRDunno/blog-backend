<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource {
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      "id" => $this->id,
      "title" => $this->title,
      "content" => $this->content,
      "created_at" => $this->created_at->diffForHumans(),
      "updated_at" => $this->updated_at->diffForHumans(),
      "user" => new UserResource($this->user),
      "liked_by_users" => UserResource::collection($this->likes),
      "like_count" => $this->likes()->count(),
    ];
  }
}
