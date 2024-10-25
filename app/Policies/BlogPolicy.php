<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Blog;

class BlogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    
    public function update(User $user, Blog $blog) {
        return $user->is($blog->user);
    }

    public function destroy(User $user, Blog $blog) {
        return $user->is($blog->user);
    }
}
