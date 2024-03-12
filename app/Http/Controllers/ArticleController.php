<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(protected ArticleRepositoryInterface $repository)
    {
        //
    }

    public function allArticles(): View
    {
        $this->authorize('viewAny', Article::class);

        $articles = auth()->user()->is_admin ? $this->repository->getAllArticleForAdmin() : $this->repository->getAll();

        return view('dashboard')->with(['articles' => $articles]);
    }

    public function index(Request $request): View
    {
        return view('article.index')->with(['articles' => $this->repository->myArticles($request->user())]);
    }

    public function show(Article $article): View
    {
        $this->authorize('view', Article::class);

        return view('article.show')->with(['article' => $article]);
    }

    public function create(): View
    {
        return view('article.create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $this->repository->store($request->validated(), $request->user());

        return redirect()->route('articles.index')->with(['message' => 'Article was created.']);
    }

    public function edit(Article $article): View
    {
        $this->authorize('edit', $article);

        return view('article.edit')->with(['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $this->authorize('update', $article);

        $this->repository->update($request->validated(), $article);

        return redirect()->route('articles.index')->with(['message' => 'Article was updated.']);
    }
}
