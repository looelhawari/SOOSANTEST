<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\PendingChange;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Owner::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }
        
        // Filter by country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        
        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        if (in_array($sortBy, ['name', 'email', 'company', 'city', 'country', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('name', 'asc');
        }
        
        $owners = $query->paginate(15)->withQueryString();
        
        // Statistics
        $totalOwners = Owner::count();
        $ownersWithEmail = Owner::whereNotNull('email')->count();
        $ownersWithCompany = Owner::whereNotNull('company')->count();
        $totalCountries = Owner::whereNotNull('country')->distinct('country')->count();
        
        // Get filter options
        $countries = Owner::whereNotNull('country')->distinct()->pluck('country')->sort();
        $cities = Owner::whereNotNull('city')->distinct()->pluck('city')->sort();
        
        return view('admin.owners.index', compact(
            'owners', 
            'totalOwners', 
            'ownersWithEmail', 
            'ownersWithCompany', 
            'totalCountries',
            'countries',
            'cities'
        ));
    }

    public function create()
    {
        return view('admin.owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:owners,email',
            'phone_number' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|string|max:10',
        ]);

        Owner::create($request->only([
            'name', 'email', 'phone_number', 'company', 
            'address', 'city', 'country', 'preferred_language'
        ]));

        return redirect()->route('admin.owners.index')
            ->with('success', __('owners.owner_created'));
    }

    public function show(Owner $owner)
    {
        $owner->load('soldProducts.product');
        return view('admin.owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('admin.owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:owners,email,' . $owner->id,
            'phone_number' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|string|max:10',
        ]);

        $updateData = $request->only([
            'name', 'email', 'phone_number', 'company', 
            'address', 'city', 'country', 'preferred_language'
        ]);

        // If user is an employee, create a pending change instead of directly updating
        if (auth()->user()->isEmployee()) {
            PendingChange::create([
                'model_type' => Owner::class,
                'model_id' => $owner->id,
                'action' => 'update',
                'original_data' => $owner->toArray(),
                'new_data' => $updateData,
                'requested_by' => auth()->id(),
            ]);

            return redirect()->route('admin.owners.index')
                ->with('info', __('admin.changes_submitted_for_approval'));
        }

        // If user is admin, apply changes directly
        $owner->update($updateData);

        return redirect()->route('admin.owners.show', $owner)
            ->with('success', __('owners.owner_updated'));
    }

    public function destroy(Owner $owner)
    {
        // If user is an employee, create a pending change instead of directly deleting
        if (auth()->user()->isEmployee()) {
            PendingChange::create([
                'model_type' => Owner::class,
                'model_id' => $owner->id,
                'action' => 'delete',
                'original_data' => $owner->toArray(),
                'new_data' => [], // No new data for deletion
                'requested_by' => auth()->id(),
            ]);

            return redirect()->route('admin.owners.index')
                ->with('info', __('admin.deletion_submitted_for_approval'));
        }

        // If user is admin, delete directly
        $owner->delete();

        return redirect()->route('admin.owners.index')
            ->with('success', __('owners.owner_deleted'));
    }
}
