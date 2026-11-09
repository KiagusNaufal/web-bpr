<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Enums\PublishStatus;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $activeType = ProductType::tryFrom((string) $request->query('jenis'));
        $products = Product::published()->orderBy('sort_order')->get();

        return view('pages.products.index', [
            'productTypes' => ProductType::cases(),
            'activeType' => $activeType,
            'productGroups' => $products->groupBy(fn (Product $p) => $p->type->value),
            'promos' => Media::where('collection', 'promo')->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->status === PublishStatus::Published, 404);

        $related = Product::published()
            ->where('type', $product->type->value)
            ->whereKeyNot($product->id)
            ->orderBy('sort_order')
            ->get();

        return view('pages.products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}
