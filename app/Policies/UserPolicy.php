<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy {
  /**
   * Create a new policy instance.
   */
  public function __construct() {
    //
  }

  public function update(User $user, User $model) {
    return $user->is($model) || $user->is_admin === 1;
  }

  public function destroy(User $user, User $model) {
    return $user->is($model) || $user->is_admin === 1;
  }
}
