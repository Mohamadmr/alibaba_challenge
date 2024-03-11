<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Article $article): bool
    {
        return $article->author()->is($user);
    }

    public function delete(User $user): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user): bool
    {
        return $user->is_admin;
    }

    public function trashed(User $user): bool
    {
        return $user->is_admin;
    }

    public function publish(User $user): bool
    {
        return $user->is_admin;
    }
}
