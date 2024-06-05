<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // hago un INSERT en la tabla likes (v134)
        $post->likes()->create([
            "user_id" => $request->user()->id,
            // "post_id" => $post->id,
        ]);

        return back();
    }
}
