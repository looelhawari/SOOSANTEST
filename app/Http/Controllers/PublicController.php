<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function homepage()
    {
        // Fetch only the 3 specific products by model_name
        $featuredProducts = Product::whereIn('model_name', [
            'SQ43 SSL Easylube',
            'SB35II SSL',
            'SB35II Top Cap',
        ])->with(['category', 'media'])->get();

        $serialLookupRoute = route('serial-lookup.index');

        return view('public.homepage', compact('featuredProducts', 'serialLookupRoute'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function privacy()
    {
        return view('public.privacy');
    }

    public function terms()
    {
        return view('public.terms');
    }

    public function support()
    {
        return view('public.support');
    }
}
