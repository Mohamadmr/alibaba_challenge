<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminArticleController extends Controller
{
    public function __construct(protected ArticleRepositoryInterface $repository)
    {
        //
    }

    public function trashed(): View
    {
        return view('trashed-dashboard')->with(['articles' => $this->repository->trashed()]);
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorize('delete', $article);

        $this->repository->delete($article);

        return redirect()->route('dashboard')->with(['message' => 'article was deleted!']);
    }

    public function show(Article $article): View
    {
        $this->authorize('view', Article::class);

        return view('article.show')->with(['article' => $article]);
    }

    public function restore(Article $article): RedirectResponse
    {
        $this->authorize('restore', $article);

        $this->repository->restore($article);

        return redirect()->route('dashboard')->with(['message' => 'article was restore!']);
    }

    public function publishArticle(Article $article): RedirectResponse
    {
        $this->authorize('publish', $article);

        $this->repository->publish($article);

        return redirect()->route('dashboard')->with(['message' => 'article was published']);
    }
}
