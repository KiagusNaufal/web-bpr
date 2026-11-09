<?php

namespace App\Http\Controllers;

use App\Enums\PublishStatus;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('cari', ''));
        $categorySlug = trim((string) $request->query('kategori', ''));

        $categories = Category::whereHas('articles', fn ($q) => $q->published())
            ->withCount(['articles' => fn ($q) => $q->published()])
            ->orderBy('name')
            ->get();

        $activeCategory = $categorySlug !== ''
            ? $categories->firstWhere('slug', $categorySlug)
            : null;

        $articles = Article::published()
            ->with('category')
            ->when($activeCategory, fn ($q) => $q->where('category_id', $activeCategory->id))
            ->search($search !== '' ? $search : null)
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'search' => $search,
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless(
            $article->status === PublishStatus::Published && $article->published_at && $article->published_at->lte(now()),
            404
        );

        $article->load(['category', 'author']);

        $related = Article::published()
            ->with('category')
            ->whereKeyNot($article->id)
            ->orderByRaw('category_id = ? desc', [$article->category_id ?? 0])
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.articles.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
