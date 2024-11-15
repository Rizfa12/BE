<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            \Log::error("Error fetching users: " . $e->getMessage());
            return response()->json(['error' => 'Could not fetch users'], 500);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }
}
