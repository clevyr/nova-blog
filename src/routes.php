<?php

use Illuminate\Support\Facades\Route;

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
Route::get(config('nova-blog.base_uri', '/blog') . '/filter', function() {
    $model = app(config('nova-blog.post_model'));

    $postsWithCategories = $model->publishedPosts()->withAnyTags([$request->type], 'post_categories')
        ->orderBy('published_at', 'desc')->get();

    $postsWithTags = $model->publishedPosts()->withAnyTags([$request->type], 'post_tags')->orderBy('published_at',
        'desc')->get();

    $posts = collect([$postsWithCategories, $postsWithTags])->flatten();

    return json_encode($posts);
});