<?php

namespace App\Services;

use App\Models\User;
use App\Models\PendingChange;
use App\Models\ContactMessage;
use App\Models\AuditLog;
use App\Notifications\NewContactMessageNotification;
use App\Notifications\NewPendingChangeNotification;
use App\Notifications\ImportantAuditLogNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send notification when a new contact message is received
     */
    public function notifyNewContactMessage(ContactMessage $contactMessage)
    {
        // Get all admin users
        $admins = User::where('role', 'admin')->get();
        
        // Send notification to all admins
        Notification::send($admins, new NewContactMessageNotification($contactMessage));
    }

    /**
     * Send notification when a new pending change is created
     */
    public function notifyNewPendingChange(PendingChange $pendingChange)
    {
        // Get all admin users
        $admins = User::where('role', 'admin')->get();
        
        // Send notification to all admins
        Notification::send($admins, new NewPendingChangeNotification($pendingChange));
    }

    /**
     * Send notification for important audit logs
     */
    public function notifyImportantAuditLog(AuditLog $auditLog)
    {
        // Define what constitutes "important" audit logs
        $importantEvents = ['deleted', 'login_failed', 'permission_denied', 'data_breach', 'system_error'];
        
        if (in_array($auditLog->event, $importantEvents)) {
            // Get all admin users
            $admins = User::where('role', 'admin')->get();
            
            // Send notification to all admins
            Notification::send($admins, new ImportantAuditLogNotification($auditLog));
        }
    }

    /**
     * Send notification to specific user
     */
    public function notifyUser(User $user, $notification)
    {
        $user->notify($notification);
    }

    /**
     * Send notification to all admins
     */
    public function notifyAllAdmins($notification)
    {
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, $notification);
    }

    /**
     * Send notification to all employees
     */
    public function notifyAllEmployees($notification)
    {
        $employees = User::where('role', '!=', 'admin')->get();
        Notification::send($employees, $notification);
    }

    /**
     * Send notification to all users
     */
    public function notifyAllUsers($notification)
    {
        $users = User::all();
        Notification::send($users, $notification);
    }
}
