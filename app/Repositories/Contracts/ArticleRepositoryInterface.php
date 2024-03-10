<?php

namespace App\Repositories\Contracts;

use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function getAll(): LengthAwarePaginator|array;

    public function myArticles(User $user): LengthAwarePaginator|array;

    public function store(array $inputs, User $user): Article;

    public function update(array $inputs, Article $article): Article;

    public function delete(Article $article): void;
}
