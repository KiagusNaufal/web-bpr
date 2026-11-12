<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Media;
use App\Models\OrganizationalStructure;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $products = Product::published()->orderBy('sort_order')->get();

        return view('pages.home', [
            'banners' => Media::where('collection', 'banner')->orderBy('sort_order')->get(),
            'products' => $products,
            'productTypes' => \App\Enums\ProductType::cases(),
            'articles' => Article::published()->with('category')->latest('published_at')->take(4)->get(),
            'articleCategories' => Category::whereHas('articles', fn ($q) => $q->published())->orderBy('name')->get(),
            'testimonials' => Testimonial::published()->orderBy('sort_order')->take(4)->get(),
            'orgChart' => Media::where('collection', 'org_chart')->latest('id')->first(),
            'structures' => OrganizationalStructure::orderBy('sort_order')->get()->groupBy('group'),
            'branches' => Branch::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
