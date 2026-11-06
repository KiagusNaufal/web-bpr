<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\Article;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $products = Product::published()->orderBy('sort_order')->get();

        return view('pages.home', [
            'banners' => Media::where('collection', 'banner')->orderBy('sort_order')->get(),
            'productGroups' => $products->groupBy(fn (Product $p) => $p->type->value),
            'productTypes' => ProductType::cases(),
            'rateRows' => $products,
            'articles' => Article::published()->with('category')->latest('published_at')->take(4)->get(),
            'branches' => Branch::where('is_active', true)->orderBy('sort_order')->get(),
            'articleCategories' => Category::whereHas('articles', fn ($q) => $q->published())->orderBy('name')->get(),
        ]);
    }
}
