<?php

namespace App\Http\Controllers;
use App\Models\Notification;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
     public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        // Ensure the authenticated user owns the notification
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->update(['read' => true]);

        return redirect()->route('dashboard')->with('success', 'Notificación marcada como leída.');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        // Ensure the authenticated user owns the notification
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return redirect()->route('dashboard')->with('success', 'Notificación eliminada.');
    }
}
