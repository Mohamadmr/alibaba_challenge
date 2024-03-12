<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Enums\ArticlePublishTypeEnum;
use App\Models\User;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    const PER_PAGE = 20;

    public function getAll(): LengthAwarePaginator|array
    {
        return Article::with('author')
            ->wherePublicationStatus(ArticlePublishTypeEnum::published)
            ->paginate(self::PER_PAGE);
    }

    public function myArticles(User $user): LengthAwarePaginator|array
    {
        return Article::whereBelongsTo($user, 'author')->paginate(self::PER_PAGE);
    }

    public function store(array $inputs, User $user): Article
    {
        return $user->articles()->create($inputs);
    }

    public function update(array $inputs, Article $article): Article
    {
        $article->update($inputs);

        return $article->fresh();
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }

    public function getAllArticleForAdmin(): LengthAwarePaginator|array
    {
        return Article::with('author')
            ->paginate(self::PER_PAGE);
    }

    public function trashed(): LengthAwarePaginator|array
    {
        return Article::with('author')
            ->onlyTrashed()
            ->paginate(self::PER_PAGE);
    }

    public function restore(Article $article): Article
    {
        $article->restore();

        return $article->fresh();
    }

    public function publish(Article $article): Article
    {
        return $article->publish()->fresh();
    }
}
