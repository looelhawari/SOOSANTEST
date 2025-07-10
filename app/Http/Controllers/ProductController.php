<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Cache sidebar filter options (5 hours)
        $filterCacheKey = 'products_filter_options';
        $filterOptions = Cache::remember($filterCacheKey, 18000, function () {
            return [
                'lines' => ['SQ Line', 'SB Line', 'SB-E Line', 'ET-II Line'],
                'types' => ['Side', 'Side Silenced', 'Top Direct', 'Top Cap', 'TR-F', 'TS-P', 'SQ Easylube', 'Backhoe', 'Backhoe Silenced', 'Skid Steer Loader'],
                'operating_weights' => ['~500kg', '500~1400kg', '1400-2000kg', '2000-3000kg', '3000-5000kg', '5000kg~'],
                'required_oil_flows' => ['~35l/min', '35-55l/min', '55-70l/min', '70-95l/min', '95-165l/min', '165l/min~'],
                'applicable_carriers' => ['~5ton', '5-14ton', '14-20ton', '20-30ton', '30-50ton', '50ton~'],
            ];
        });

        // Validate and sanitize input
        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
            'line' => 'array',
            'line.*' => 'string|max:20',
            'type' => 'array',
            'type.*' => 'string|max:30',
            'operating_weight' => 'array',
            'operating_weight.*' => 'string|max:20',
            'required_oil_flow' => 'array',
            'required_oil_flow.*' => 'string|max:20',
            'applicable_carrier' => 'array',
            'applicable_carrier.*' => 'string|max:20',
            'unit' => 'nullable|in:si,imperial',
        ]);

        $query = Product::with('category'); // Eager load category
        // Search by model_name (case-insensitive, sanitized)
        if ($request->filled('search')) {
            $searchTerm = htmlspecialchars($request->search, ENT_QUOTES, 'UTF-8');
            $query->where('model_name', 'like', "%{$searchTerm}%");
        }
        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        // Line filter
        if ($request->filled('line')) {
            $query->where('line', $request->line);
        }
        // Type filter
        if ($request->filled('type')) {
            $query->whereIn('type', (array)$request->type);
        }
        // Operating Weight filter (range)
        if ($request->filled('operating_weight')) {
            $query->where(function($q) use ($request) {
                foreach ($request->operating_weight as $range) {
                    switch ($range) {
                        case '~500kg':
                            $q->orWhere('operating_weight', '<', 500);
                            break;
                        case '500~1400kg':
                            $q->orWhereBetween('operating_weight', [500, 1400]);
                            break;
                        case '1400-2000kg':
                            $q->orWhereBetween('operating_weight', [1400, 2000]);
                            break;
                        case '2000-3000kg':
                            $q->orWhereBetween('operating_weight', [2000, 3000]);
                            break;
                        case '3000-5000kg':
                            $q->orWhereBetween('operating_weight', [3000, 5000]);
                            break;
                        case '5000kg~':
                            $q->orWhere('operating_weight', '>=', 5000);
                            break;
                    }
                }
            });
        }
        // Required Oil Flow filter (range)
        if ($request->filled('required_oil_flow')) {
            $query->where(function($q) use ($request) {
                foreach ($request->required_oil_flow as $range) {
                    switch ($range) {
                        case '~35l/min':
                            $q->orWhereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', 1) AS DECIMAL(8,2)) < 35");
                            break;
                        case '35-55l/min':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', 1) AS DECIMAL(8,2)) >= 35")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', -1) AS DECIMAL(8,2)) <= 55");
                            });
                            break;
                        case '55-70l/min':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', 1) AS DECIMAL(8,2)) >= 55")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', -1) AS DECIMAL(8,2)) <= 70");
                            });
                            break;
                        case '70-95l/min':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', 1) AS DECIMAL(8,2)) >= 70")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', -1) AS DECIMAL(8,2)) <= 95");
                            });
                            break;
                        case '95-165l/min':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', 1) AS DECIMAL(8,2)) >= 95")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', -1) AS DECIMAL(8,2)) <= 165");
                            });
                            break;
                        case '165l/min~':
                            $q->orWhereRaw("CAST(SUBSTRING_INDEX(required_oil_flow, '~', -1) AS DECIMAL(8,2)) > 165");
                            break;
                    }
                }
            });
        }
        // Applicable Carrier filter (range)
        if ($request->filled('applicable_carrier')) {
            $query->where(function($q) use ($request) {
                foreach ($request->applicable_carrier as $range) {
                    switch ($range) {
                        case '~5ton':
                            $q->orWhereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', 1) AS DECIMAL(8,2)) < 5");
                            break;
                        case '5-14ton':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', 1) AS DECIMAL(8,2)) >= 5")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', -1) AS DECIMAL(8,2)) <= 14");
                            });
                            break;
                        case '14-20ton':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', 1) AS DECIMAL(8,2)) >= 14")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', -1) AS DECIMAL(8,2)) <= 20");
                            });
                            break;
                        case '20-30ton':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', 1) AS DECIMAL(8,2)) >= 20")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', -1) AS DECIMAL(8,2)) <= 30");
                            });
                            break;
                        case '30-50ton':
                            $q->orWhere(function($sub) {
                                $sub->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', 1) AS DECIMAL(8,2)) >= 30")
                                    ->whereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', -1) AS DECIMAL(8,2)) <= 50");
                            });
                            break;
                        case '50ton~':
                            $q->orWhereRaw("CAST(SUBSTRING_INDEX(applicable_carrier, '~', -1) AS DECIMAL(8,2)) > 50");
                            break;
                    }
                }
            });
        }
        // Only select required fields for the card
        $query->select(['id', 'model_name', 'operating_weight', 'required_oil_flow', 'applicable_carrier', 'line', 'type', 'image_url', 'category_id']);
        $products = $query->paginate(12)->withQueryString();
        $lines = $filterOptions['lines'];
        $types = $filterOptions['types'];
        $operating_weights = $filterOptions['operating_weights'];
        $required_oil_flows = $filterOptions['required_oil_flows'];
        $applicable_carriers = $filterOptions['applicable_carriers'];
        $unit = $request->get('unit', 'imperial');
        $search = $request->get('search', '');
        return view('public.products.index', compact('products', 'lines', 'types', 'operating_weights', 'required_oil_flows', 'applicable_carriers', 'unit', 'search'));
    }

    public function show($id)
    {
        $cacheKey = 'product_details_' . $id;
        try {
            $product = Cache::remember($cacheKey, 3600, function () use ($id) {
                return Product::with('category')->select([
                    'id',
                    'model_name',
                    'body_weight',
                    'operating_weight',
                    'overall_length',
                    'overall_width',
                    'overall_height',
                    'required_oil_flow',
                    'operating_pressure',
                    'impact_rate',
                    'impact_rate_soft_rock',
                    'hose_diameter',
                    'rod_diameter',
                    'applicable_carrier',
                    'image_url',
                    'category_id'
                ])->findOrFail($id);
            });
        } catch (\Throwable $e) {
            $product = Product::with('category')->select([
                'id',
                'model_name',
                'body_weight',
                'operating_weight',
                'overall_length',
                'overall_width',
                'overall_height',
                'required_oil_flow',
                'operating_pressure',
                'impact_rate',
                'impact_rate_soft_rock',
                'hose_diameter',
                'rod_diameter',
                'applicable_carrier',
                'image_url',
                'category_id'
            ])->findOrFail($id);
        }
        $unit = request()->get('unit', 'imperial');
        return view('public.products.show', compact('product', 'unit'));
    }

    public function category(ProductCategory $category)
    {
        $cacheKey = 'products_category_' . $category->id;
        $products = Cache::remember($cacheKey, 600, function () use ($category) {
            return Product::where('category_id', $category->id)
                ->with(['category', 'media'])
                ->paginate(12);
        });
        return view('public.products.category', compact('category', 'products'));
    }
}
