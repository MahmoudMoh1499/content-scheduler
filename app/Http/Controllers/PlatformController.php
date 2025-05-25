<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Models\User;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        return response()->json([
            'platforms' => Platform::all(),
            'user_platforms' => auth()->user()->platforms->pluck('id')
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'platform_ids' => 'required|array',
            'platform_ids.*' => 'exists:platforms,id'
        ]);

        auth()->user()->platforms()->sync($request->platform_ids);

        return response()->json([
            'message' => 'Platforms updated successfully',
            'active_platforms' => auth()->user()->platforms
        ]);
    }
}
