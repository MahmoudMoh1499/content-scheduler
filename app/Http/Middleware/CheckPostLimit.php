<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckPostLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $postsToday = $user->posts()
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($postsToday >= 10) {
            return response()->json([
                'message' => 'You have reached your daily post limit (10 posts per day)'
            ], 429);
        }

        return $next($request);
    }
}
