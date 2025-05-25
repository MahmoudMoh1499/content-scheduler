<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Platform;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Cache\RateLimiter;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->user()->posts()->with('platforms');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('scheduled_time', $request->date);
        }

        return response()->json($query->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $limiter = app(RateLimiter::class);
        $key = 'posts:' . $request->user()->id;

        if ($limiter->tooManyAttempts($key, 10)) {
            return response()->json([
                'message' => 'Daily post limit (10) reached'
            ], 429);
        }

        $limiter->hit($key, 86400);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'scheduled_time' => 'required|date|after:now',
            'platforms' => 'required|array',
            'platforms.*' => 'exists:platforms,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($request->platforms as $platformId) {
            $platform = Platform::find($platformId);
            $this->validatePlatformRequirements($platform, $request->content);
        }

        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'scheduled_time' => Carbon::parse($request->scheduled_time),
            'status' => 'scheduled',
        ]);

        $post->platforms()->attach($request->platforms);

        return response()->json($post->load('platforms'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return response()->json($post->load('platforms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'image_url' => 'nullable|url',
            'scheduled_time' => 'sometimes|date|after:now',
            'platforms' => 'sometimes|array',
            'platforms.*' => 'exists:platforms,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('content') || $request->has('platforms')) {
            $platforms = $request->has('platforms')
                ? $request->platforms
                : $post->platforms->pluck('id')->toArray();

            foreach ($platforms as $platformId) {
                $platform = Platform::find($platformId);
                $content = $request->content ?? $post->content;
                $this->validatePlatformRequirements($platform, $content);
            }
        }

        $post->update($request->only(['title', 'content', 'image_url', 'scheduled_time']));

        if ($request->has('platforms')) {
            $post->platforms()->sync($request->platforms);
        }

        return response()->json($post->fresh()->load('platforms'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(null, 204);
    }

    protected function validatePlatformRequirements($platform, $content)
    {
        if ($platform->character_limit && strlen($content) > $platform->character_limit) {
            abort(422, "Content exceeds {$platform->name}'s character limit of {$platform->character_limit}");
        }

    }
}
