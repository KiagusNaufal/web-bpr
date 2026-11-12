<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $categoryId = $request->integer('category_id') ?: null;
        $activeStatus = PublishStatus::tryFrom((string) $request->query('status'));
        $search = trim((string) $request->query('q'));

        $articles = Article::with(['category', 'author'])
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->when($activeStatus, fn ($q) => $q->where('status', $activeStatus->value))
            ->when($search !== '', fn ($q) => $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            }))
            ->latest('published_at')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => Category::withCount('articles')->orderBy('name')->get(),
            'statuses' => PublishStatus::cases(),
            'activeCategoryId' => $categoryId,
            'activeStatus' => $activeStatus,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article([
                'status' => PublishStatus::Published,
                'published_at' => now(),
            ]),
            'categories' => Category::orderBy('name')->get(),
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $request->user()?->id;

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel informasi berhasil diterbitkan.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $this->validatedData($request, $article);
        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
        ]);

        Category::firstOrCreate(
            ['slug' => Str::slug($validated['name'])],
            ['name' => $validated['name']]
        );

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    private function validatedData(Request $request, ?Article $article = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('articles', 'slug')->ignore($article?->id)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:360'],
            'body' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:3072'],
            'status' => ['required', Rule::enum(PublishStatus::class)],
            'published_at' => ['nullable', 'date'],
        ]);

        $categoryId = $validated['category_id'] ?? null;
        if (! empty($validated['new_category'])) {
            $cat = Category::firstOrCreate(
                ['slug' => Str::slug($validated['new_category'])],
                ['name' => trim($validated['new_category'])]
            );
            $categoryId = $cat->id;
        }

        $slug = Str::slug(($validated['slug'] ?? '') ?: $validated['title']);
        if (! $article && Article::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::lower(Str::random(4));
        }

        $data = [
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $categoryId,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? now(),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('articles', 'public');
        }

        return $data;
    }
}
