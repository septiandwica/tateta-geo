<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by endpoint
        if ($request->filled('endpoint')) {
            $query->where('endpoint', 'like', '%' . $request->endpoint . '%');
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Display the specified activity log
     */
    public function show(ActivityLog $activity)
    {
        $activity->load('user');
        return view('admin.activities.show', compact('activity'));
    }
}
