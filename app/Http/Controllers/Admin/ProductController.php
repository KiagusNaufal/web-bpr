<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductType;
use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::orderBy('type')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(['status' => PublishStatus::Published, 'type' => ProductType::Tabungan, 'sort_order' => 0]),
            'types' => ProductType::cases(),
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['created_by'] = $request->user()?->id;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'types' => ProductType::cases(),
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Perubahan produk berhasil disimpan.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:140'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('products', 'slug')->ignore($product?->id)],
            'type' => ['required', Rule::enum(ProductType::class)],
            'summary' => ['required', 'string', 'max:320'],
            'description' => ['nullable', 'string'],
            'rate_info' => ['nullable', 'string', 'max:120'],
            'tenor_info' => ['nullable', 'string', 'max:120'],
            'min_amount_info' => ['nullable', 'string', 'max:120'],
            'fee_info' => ['nullable', 'string', 'max:120'],
            'terms' => ['nullable', 'string'],
            'benefits_text' => ['nullable', 'string'],
            'requirements_text' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:3072'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', Rule::enum(PublishStatus::class)],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $slug = Str::slug(($validated['slug'] ?? '') ?: $validated['name']);
        if (! $product && Product::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::lower(Str::random(4));
        }

        $data = [
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
            'summary' => $validated['summary'],
            'description' => $validated['description'] ?? null,
            'rate_info' => $validated['rate_info'] ?? null,
            'tenor_info' => $validated['tenor_info'] ?? null,
            'min_amount_info' => $validated['min_amount_info'] ?? null,
            'fee_info' => $validated['fee_info'] ?? null,
            'terms' => $validated['terms'] ?? null,
            'benefits' => $this->linesToArray($validated['benefits_text'] ?? ''),
            'requirements' => $this->linesToArray($validated['requirements_text'] ?? ''),
            'is_featured' => $request->boolean('is_featured'),
            'status' => $validated['status'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        return $data;
    }

    private function linesToArray(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $text))));
    }
}
