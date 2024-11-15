<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display the staff dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboard()
    {
        // Sample data for staff dashboard
        return response()->json([
            'success' => true,
            'message' => 'Welcome to the Staff Dashboard!',
            'data' => [
                // Staff-specific data
                'tasks_assigned' => 5, // Example data
                'projects_involved' => 2,
            ]
        ], 200);
    }
}
