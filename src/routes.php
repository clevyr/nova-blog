<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * Return json data for a specific post by slug
 */
Route::get(
    config('nova-blog.base_uri', '/blog') . config('nova-blog.post_base_uri', '/post') . '/{slug}',
    function($slug)
    {
        $model = app(config('nova-blog.post_model'));
        $post = $model->publishedPosts()->where('slug', $slug)->first();
        return json_encode($post);
    }
);

/**
 * Return json data for all published posts
 */
Route::get(config('nova-blog.base_uri', '/blog') . '/get-published-posts', function() {
    $model = app(config('nova-blog.post_model'));
    $posts = $model->publishedPosts()->orderBy('published_at', 'desc')->get();
    return $posts;
});

/**
 * Return json data for all published posts with a certain category or tag applied
 */
Route::get(config('nova-blog.base_uri', '/blog') . '/filter', function(Request $request) {
    $model = app(config('nova-blog.post_model'));

    $posts = $model->publishedPosts()->get();

    $posts = $posts->filter(function ($post) use ($request) {
        $found = false;

        foreach($post->post_categories as $key => $cat) {
            if (strtolower($cat->slug) === strtolower($request->type)) {
                $found = true;
            }
        }

        foreach($post->post_tags as $key => $tag) {
            if (strtolower($tag->slug) === strtolower($request->type)) {
                $found = true;
            }
        }

        return $found;
    });

    return json_encode($posts->flatten());
});
