<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendingChange;
use Illuminate\Http\Request;

class PendingChangeController extends Controller
{
    public function index()
    {
        // Only admins can view pending changes
        if (!auth()->user()->isAdmin()) {
            abort(403, __('admin.admin_only_access'));
        }

        $pendingChanges = PendingChange::with(['requestedBy', 'reviewedBy'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.pending-changes.index', compact('pendingChanges'));
    }

    public function show(PendingChange $pendingChange)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, __('admin.admin_only_access'));
        }

        $pendingChange->load(['requestedBy', 'reviewedBy']);
        return view('admin.pending-changes.show', compact('pendingChange'));
    }

    public function approve(Request $request, PendingChange $pendingChange)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, __('admin.admin_only_access'));
        }

        if (!$pendingChange->isPending()) {
            return redirect()->back()->with('error', 'This change has already been reviewed.');
        }

        $request->validate([
            'review_notes' => 'nullable|string|max:500'
        ]);

        try {
            $pendingChange->approve(auth()->user(), $request->review_notes);
            return redirect()->route('admin.pending-changes.index')
                ->with('success', __('admin.change_approved'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('admin.change_approval_failed') . ': ' . $e->getMessage());
        }
    }

    public function reject(Request $request, PendingChange $pendingChange)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, __('admin.admin_only_access'));
        }

        if (!$pendingChange->isPending()) {
            return redirect()->back()->with('error', __('admin.change_already_reviewed'));
        }

        $request->validate([
            'review_notes' => 'required|string|max:500'
        ]);

        try {
            $pendingChange->reject(auth()->user(), $request->review_notes);
            
            return redirect()->route('admin.pending-changes.index')
                ->with('success', __('admin.change_rejected'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('admin.change_rejection_failed') . ': ' . $e->getMessage());
        }
    }

    public function history()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, __('admin.admin_only_access'));
        }

        $changes = PendingChange::with(['requestedBy', 'reviewedBy'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('reviewed_at')
            ->paginate(20);

        return view('admin.pending-changes.history', compact('changes'));
    }
}
