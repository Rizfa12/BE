<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboard()
    {
        // Sample data for admin dashboard
        return response()->json([
            'success' => true,
            'message' => 'Welcome to the Admin Dashboard!',
            'data' => [
                // Admin-specific data
                'total_users' => 150, // Example data
                'total_sales' => 3000,
            ]
        ], 200);
    }
}
