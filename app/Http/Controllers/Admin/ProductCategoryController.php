<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('name')->paginate(15);
        return view('admin.product-categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.product-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        $data = $request->except(['icon', '_token']);
        $data['slug'] = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        $category = ProductCategory::create($data);

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('categories', 'public');
            $category->icon_url = '/storage/' . $iconPath;
            $category->save();
        }

        return redirect()->route('admin.product-categories.index')
            ->with('success', __('product_categories.category_created'));
    }

    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::where('id', '!=', $productCategory->id)->orderBy('name')->get();
        return view('admin.product-categories.edit', compact('productCategory', 'categories'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $productCategory->id,
            'slug' => 'nullable|string|max:255|unique:product_categories,slug,' . $productCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        $data = $request->except(['icon', '_token', '_method']);
        $data['slug'] = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        $productCategory->update($data);

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('categories', 'public');
            $productCategory->icon_url = '/storage/' . $iconPath;
            $productCategory->save();
        }

        return redirect()->route('admin.product-categories.index')
            ->with('success', __('product_categories.category_updated'));
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect()->route('admin.product-categories.index')
            ->with('success', __('product_categories.category_deleted'));
    }

    public function show(ProductCategory $productCategory)
    {
        $productCategory->loadCount('products');
        $productCategory->load(['children' => function ($query) {
            $query->withCount('products');
        }]);

        return view('admin.product-categories.show', ['category' => $productCategory]);
    }
}
