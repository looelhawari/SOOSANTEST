<?php

namespace App\Http\Controllers;

use App\Models\PendingChange;
use App\Models\User;
use App\Notifications\ChangeRejectedNotification;
use Illuminate\Http\Request;

class TestNotificationController extends Controller
{
    public function testRejectChange()
    {
        // Find a test user (you can create one or use an existing one)
        $testEmployee = User::where('role', '!=', 'admin')->first();
        
        if (!$testEmployee) {
            return response()->json(['error' => 'No non-admin user found for testing']);
        }
        
        // Create a mock pending change
        $pendingChange = new PendingChange();
        $pendingChange->model_type = 'App\Models\Product';
        $pendingChange->model_id = 1;
        $pendingChange->action = 'update';
        $pendingChange->original_data = ['name' => 'Old Product Name'];
        $pendingChange->new_data = ['name' => 'New Product Name'];
        $pendingChange->requested_by = $testEmployee->id;
        $pendingChange->status = 'rejected';
        $pendingChange->reviewed_by = auth()->user()->id;
        $pendingChange->reviewed_at = now();
        $pendingChange->review_notes = 'This is a test rejection. The product name change was not approved because it does not meet our naming standards.';
        
        // Create relationships manually for testing
        $pendingChange->setRelation('requestedBy', $testEmployee);
        $pendingChange->setRelation('reviewedBy', auth()->user());
        
        // Send the notification
        $testEmployee->notify(new ChangeRejectedNotification($pendingChange));
        
        return response()->json([
            'success' => true,
            'message' => 'Test notification sent to ' . $testEmployee->name,
            'notification_count' => $testEmployee->unreadNotifications->count()
        ]);
    }
}
